<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductLabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'ASC')->get();

        return view('pages._Main.Ecommerce.product.index', compact('products'));
    }

    public function list()
    {
        $products = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_labels', 'products.product_label_id', '=', 'product_labels.id')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->select(
                'products.*',
                'product_categories.name as category_name',
                'product_labels.name as label_name',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('ROUND(AVG(reviews.rating), 1) as rating_avg'),
            )
            ->orderBy('products.created_at', 'ASC')
            ->when(request()->q, function ($products) {
                $products = $products->where('products.name', 'like', '%' . request()->q . '%');
            })
            ->when(request()->slug, function ($products) {
                $products = $products->where('products.slug', 'like', '%' . request()->slug . '%');
            })
            ->when(request()->filter, function ($products) {
                if (request()->filter == 'active') {
                    $products = $products->where('products.is_active', '=', 1);
                } elseif (request()->filter == 'draft') {
                    $products = $products->where('products.is_active', '=', 0);
                }
            })
            ->when(request()->sort, function ($products) {
                if (request()->sort == 'newest') {
                    $products = $products->orderBy('products.created_at', 'DESC');
                } elseif (request()->sort == 'oldest') {
                    $products = $products->orderBy('products.created_at', 'ASC');
                } elseif (request()->sort == 'price_asc') {
                    $products = $products->orderBy('products.price', 'ASC');
                } elseif (request()->sort == 'price_desc') {
                    $products = $products->orderBy('products.price', 'DESC');
                }
            })
            ->when(request()->category, function ($products) {
                $products = $products->where('products.product_category_id', '=', request()->category);
            })
            ->when(request()->label, function ($products) {
                $products = $products->where('products.product_label_id', '=', request()->label);
            })
            ->groupBy('products.id', 'product_categories.name', 'product_labels.name')
            ->paginate(6);

        $categories = DB::table('product_categories')->get();
        $labels = DB::table('product_labels')->get();

        return view('pages._Main.Ecommerce.product.list', compact('products', 'categories', 'labels'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        $labels = ProductLabel::all();

        return view('pages._Main.Ecommerce.product.add', compact('categories', 'labels'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                // 'name'                  => 'required|unique:products, name',
                // name unique:products, name where delete_at is null
                'name'                  => 'required|unique:products,name,NULL,id,deleted_at,NULL',
                'slug'                  => 'required|unique:products,slug,NULL,id,deleted_at,NULL',
                'description'           => 'required',
                'thumbnail'             => 'required',
                'images'                => 'required',
                'price'                 => 'required',
                'weight'                => 'required',
                'is_active'             => 'required',
                'shipment'              => 'required',
                'payment'               => 'required',
                'product_category_id'   => 'required',
                'product_label_id'      => 'required',
            ],
            [
                'name.required'                 => 'Nama produk harus diisi',
                'slug.required'                 => 'Slug produk harus diisi',
                'name.unique'                   => 'Nama produk sudah ada',
                'slug.unique'                   => 'Slug produk sudah ada',
                'description.required'          => 'Deskripsi produk harus diisi',
                'thumbnail.required'            => 'Thumbnail produk harus diisi',
                'images.required'               => 'Gambar produk harus diisi',
                'price.required'                => 'Harga produk harus diisi',
                'weight.required'               => 'Berat produk harus diisi',
                'is_active.required'            => 'Status produk harus diisi',
                'shipment.required'             => 'Pengiriman produk harus diisi',
                'payment.required'              => 'Pembayaran produk harus diisi',
                'product_category_id.required'  => 'Kategori produk harus diisi',
                'product_label_id.required'     => 'Label produk harus diisi',
            ]
        );


        if ($request->slug == null) {
            $slug = str_replace(' ', '-', strtolower($request->name));
        } else {
            $slug = $request->slug;
        }

        if ($request->thumbnail != null) {
            $path = $request->thumbnail;
            $filename = explode('/', $path);

            $directory = explode('/', $path);
            array_pop($directory);
            $directory = implode('/', $directory);

            if (!File::exists(public_path('images/products/' . $slug . '/thumbnail'))) {
                File::makeDirectory(public_path('images/products/' . $slug . '/thumbnail'), 0777, true, true);
            }

            File::move(storage_path('app/' . $path), public_path('images/products/' . $slug . '/' . 'thumbnail/' . $filename[3]));
            File::deleteDirectory(storage_path('app/' . $directory));

            $urlThumbnailFile = url('images/products/' . $slug . '/' . 'thumbnail/' . $filename[3]);
        };

        $arrImages = json_decode($request->images);
        if ($request->images != null && is_array($arrImages)) {
            foreach ($arrImages as $path) {
                $filename = explode('/', $path);

                $directory = explode('/', $path);
                array_pop($directory);
                $directory = implode('/', $directory);

                if (!File::exists(public_path('images/products/' . $slug . '/images'))) {
                    File::makeDirectory(public_path('images/products/' . $slug . '/images'), 0777, true, true);
                }

                File::move(storage_path('app/' . $path), public_path('images/products/' . $slug . '/images/' . $filename[3]));
                File::deleteDirectory(storage_path('app/' . $directory));
            }

            $urlProductImages = array_map(function ($path) use ($slug) {
                $filename = explode('/', $path);
                return url('images/products/' . $slug . '/images/' . $filename[3]);
            }, $arrImages);
        };

        $product = Product::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name ?? null,
            'slug' => $slug ?? null,
            'description' => $request->description ?? null,
            'tags' => json_encode($request->tags) ?? null,
            'thumbnail' => $urlThumbnailFile ?? null,
            'price' => $request->price ?? null,
            'weight' => $request->weight ?? null,
            'dimension' => $request->dimension,
            'discount' => $request->discount ?? null,
            'status' => $request->is_active == true ? 'active' : 'draft',
            'is_active' => $request->is_active ?? false,
            'is_preorder' => $request->is_preorder ?? false,
            'preorder_duration' => $request->preorder_duration ?? null,
            'shipment' => json_encode($request->shipment) ?? null,
            'payment' => json_encode($request->payment) ?? null,
            'product_category_id' => $request->product_category_id ?? null,
            'product_label_id' => $request->product_label_id ?? null,
        ]);

        if ($request->images != null && is_array($arrImages)) {
            $product->productImages()->createMany(
                array_map(function ($path) use ($slug) {
                    $filename = explode('/', $path);
                    return [
                        'image' => url('images/products/' . $slug . '/images/' . $filename[3]),
                    ];
                }, $arrImages)
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
        ], 200);
    }

    public function getProducts()
    {
        $products = Product::where('name', 'ILIKE', '%' . request()->q . '%')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
        ], 200);
    }

    public function show($slug)
    {
        $product = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.id')
            ->leftJoin('orders', 'products.id', '=', 'orders.product_id')
            ->select(
                'products.*',
                'product_categories.name as category_name',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('ROUND(AVG(reviews.rating), 1) as rating_avg'),
                DB::raw('CAST(products.price AS INTEGER) as product_price'),
                DB::raw('CAST(products.price - (products.price * products.discount / 100) AS INTEGER) as price_after_discount'),
            )
            ->addSelect(DB::raw('SUM(orders.quantity) as order_quantity'))
            ->where('products.slug', '=', $slug)
            ->groupBy('products.id', 'product_categories.name')
            ->first();

        // dd($product);

        // review list
        $reviews = DB::table('reviews')
            ->join('customers', 'reviews.id', '=', 'customers.id')
            ->select(
                'reviews.*',
                'customers.name as customer_name',
                'customers.email as customer_email',
                'customers.avatar as customer_avatar',
            )
            ->where('reviews.id', '=', $product->id)
            ->orderBy('reviews.created_at', 'DESC')
            ->get();

        // product image list
        $productImages = DB::table('product_images')
            ->select('product_images.*')
            ->where('product_images.product_id', '=', $product->id)
            ->orderBy('product_images.created_at', 'ASC')
            ->get();

        // related products by category
        $relatedProducts = DB::table('products')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->join('product_labels', 'products.product_label_id', '=', 'product_labels.id')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.id')
            ->select(
                'products.*',
                'product_categories.name as category_name',
                'product_labels.name as label_name',
                DB::raw('COUNT(reviews.id) as review_count'),
                DB::raw('ROUND(AVG(reviews.rating), 1) as rating_avg'),
                DB::raw('CAST(products.price AS INTEGER) as product_price'),
                DB::raw('CAST(products.price - (products.price * products.discount / 100) AS INTEGER) as price_after_discount'),
            )
            ->where('products.product_category_id', '=', $product->product_category_id)
            ->where('products.id', '!=', $product->id)
            ->orderBy('products.created_at', 'DESC')
            ->groupBy('products.id', 'product_categories.name', 'product_labels.name')
            ->limit(4)
            ->get();

        if (!$product) {
            return abort(404);
        }

        return view('pages._Main.Ecommerce.product.detail', compact(
            'product',
            'reviews',
            'productImages',
            'relatedProducts',
        ));
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        // dd($product = Product::find($id));

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus',
        ], 200);
    }

    public function edit($id)
    {
        $product = Product::where('id', '=', $id)->first();

        $productImages = DB::table('product_images')
            ->select('product_images.*')
            ->where('product_images.product_id', '=', $product->id)
            ->orderBy('product_images.created_at', 'ASC')
            ->get();

        // set product images to array
        $arrProductImages = [];
        foreach ($productImages as $productImage) {
            array_push($arrProductImages, $productImage->image);
        }
        // to string
        $arrProductImages = json_encode($arrProductImages);

        if (!$product) {
            return abort(404);
        }

        $categories = ProductCategory::all();
        $labels = ProductLabel::all();

        return view('pages._Main.Ecommerce.product.edit', compact(
            'product',
            'categories',
            'labels',
            'arrProductImages',
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:products,name,' . $id,
            'slug' => 'unique:products,slug,' . $id,
            'description' => 'required',
            'price' => 'required',
            'weight' => 'required',
            'dimension' => 'required',
            'product_category_id' => 'required',
        ]);

        if ($request->slug == null) {
            $slug = str_replace(' ', '-', strtolower($request->name));
        } else {
            $slug = $request->slug;
        }

        if ($request->thumbnail != null) {
            $path = $request->thumbnail;
            $filename = explode('/', $path);

            $directory = explode('/', $path);
            array_pop($directory);
            $directory = implode('/', $directory);

            if (!File::exists(public_path('images/products/' . $slug . '/thumbnail'))) {
                File::makeDirectory(public_path('images/products/' . $slug . '/thumbnail'), 0777, true, true);
            }

            File::move(storage_path('app/' . $path), public_path('images/products/' . $slug . '/' . 'thumbnail/' . $filename[3]));
            File::deleteDirectory(storage_path('app/' . $directory));

            $urlThumbnailFile = url('images/products/' . $slug . '/' . 'thumbnail/' . $filename[3]);
        };

        $arrImages = json_decode($request->images);
        if ($request->images != null && is_array($arrImages)) {
            foreach ($arrImages as $path) {
                $filename = explode('/', $path);

                $directory = explode('/', $path);
                array_pop($directory);
                $directory = implode('/', $directory);

                if (!File::exists(public_path('images/products/' . $slug . '/images'))) {
                    File::makeDirectory(public_path('images/products/' . $slug . '/images'), 0777, true, true);
                }

                File::move(storage_path('app/' . $path), public_path('images/products/' . $slug . '/images/' . $filename[3]));
                File::deleteDirectory(storage_path('app/' . $directory));
            }

            $urlProductImages = array_map(function ($path) use ($slug) {
                $filename = explode('/', $path);
                return url('images/products/' . $slug . '/images/' . $filename[3]);
            }, $arrImages);
        };

        $product = Product::find($id);
        $product->update([
            'user_id' => auth()->user()->id,
            'name' => $request->name ?? null,
            'slug' => $slug ?? null,
            'description' => $request->description ?? null,
            'tags' => json_encode($request->tags) ?? null,
            'thumbnail' => $urlThumbnailFile ?? null,
            'price' => $request->price ?? null,
            'weight' => $request->weight ?? null,
            'dimension' => $request->dimension,
            'discount' => $request->discount ?? null,
            'status' => $request->is_active == true ? 'active' : 'draft',
            'is_active' => $request->is_active ?? false,
            'is_preorder' => $request->is_preorder ?? false,
            'preorder_duration' => $request->preorder_duration ?? null,
            'shipment' => json_encode($request->shipment) ?? null,
            'payment' => json_encode($request->payment) ?? null,
            'product_category_id' => $request->product_category_id ?? null,
            'product_label_id' => $request->product_label_id ?? null,
        ]);
        if ($request->images != null && is_array($arrImages)) {
            // delete old product images
            DB::table('product_images')->where('product_id', '=', $product->id)->delete();

            // insert new product images
            foreach ($urlProductImages as $urlProductImage) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $urlProductImage,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diubah',
        ], 200);
    }
}
