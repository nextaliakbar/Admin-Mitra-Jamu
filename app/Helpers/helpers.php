<?php

use Illuminate\Support\Str;

function responseToast($status, $message, $data = null, $code = 200)
{
  $response = [
    'status' => $status,
    'message' => $message,
    'title' => ucfirst($status),
  ];
  return response()->json($response, $code);
}

function responseJson($status, $message, $data = null, $code = 200)
{
  $response = [
    'status' => $status,
    'message' => $message,
    'data' => $data
  ];
  return response()->json($response, $code);
}

if (!function_exists('moneyFormat')) {
  function moneyFormat($str)
  {
    return 'Rp ' . number_format($str, '0', '', '.');
  }
}

function generateInvoiceNumber($param)
{
  $length = 10;
  $random = '';
  for ($i = 0; $i < $length; $i++) {
    $random .= rand(0, 9);
  }
  if ($param) {
    $invoice = 'INV/' . date('Ymd') . '/' . $param . '/' . $random;
    return $invoice;
  }
  return false;
}

function dataCourier($data)
{
  if ($data == "POS Indonesia (POS)") {
    return "pos";
  } elseif ($data == "Jalur Nugraha Ekakurir (JNE)") {
    return "jne";
  } elseif ($data == "SiCepat Express") {
    return "sicepat";
  } elseif ($data == "J&T Express") {
    return "jnt";
  } elseif ($data == "AnterAja") {
    return "anteraja";
  } else {
    return false;
  }
}

function conditionStatus($status)
{
  switch ($status) {
    case 'WORSENED':
      return 'Memburuk';
    case 'IMPROVED':
      return 'Membaik';
    case 'HEALED':
      return 'Sembuh';
    case 'DIED':
      return 'Mati';
    default:
      return '';
  }
}

function truncateText(string $text, int $length = 20): string
{
  if (strlen($text) <= $length) {
    return $text;
  }
  $text = substr($text, 0, $length);
  $text = substr($text, 0, strrpos($text, " "));
  $text .= "...";
  return $text;
}
