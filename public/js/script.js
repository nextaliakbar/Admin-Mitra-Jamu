const dataTableInit = (tableId) => {
  $(tableId).DataTable({
    language: {
      paginate: {
        previous: "<i class='mdi mdi-chevron-left'>",
        next: "<i class='mdi mdi-chevron-right'>",
      },
    },
    drawCallback: function () {
      $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
      $('.page-link').attr('style', 'border-radius: 4px !important');
    },
    columnDefs: [
      {
        targets: -1,
        orderable: false,
      },
    ],
  });
};

const toastSuccess = (message) => {
  Toastify({
    text: message,
    duration: 3000,
    newWindow: true,
    close: true,
    gravity: 'top',
    position: 'center',
    style: {
      background: '#2A3042',
      color: '#FFFFFF',
      borderRadius: '5px',
    },
    avatar: 'https://img.icons8.com/color/48/000000/ok.png',
    stopOnFocus: true,
    onClick: function () {},
  }).showToast();
};

const toastWarning = (message) => {
  Toastify({
    text: message,
    duration: 3000,
    newWindow: true,
    close: true,
    gravity: 'top',
    position: 'center',
    stopOnFocus: true,
    style: {
      background: '#2A3042',
      color: '#FFFFFF',
      borderRadius: '5px',
    },
    avatar: 'https://img.icons8.com/color/48/000000/error.png',
    onClick: function () {},
  }).showToast();
};

const toastError = (message) => {
  Toastify({
    text: message,
    duration: 3000,
    newWindow: true,
    close: true,
    gravity: 'top',
    position: 'center',
    style: {
      background: '#2A3042',
      color: '#FFFFFF',
      borderRadius: '5px',
    },
    avatar: 'https://img.icons8.com/color/48/000000/cancel.png',
    stopOnFocus: true,
    onClick: function () {},
  }).showToast();
};

const loadBtn = (btnId) => {
  $(btnId)
    .html(`<i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i> Loading...`)
    .addClass('disabled');
};

const select2Init = (selectId) => {
  $(selectId).select2({
    ajax: {
      url: 'https://api.github.com/search/repositories',
      dataType: 'json',
      delay: 250,
      data: function (e) {
        return { q: e.term, page: e.page };
      },
      processResults: function (e, t) {
        return (
          (t.page = t.page || 1),
          {
            results: e.items,
            pagination: { more: 30 * t.page < e.total_count },
          }
        );
      },
      cache: !0,
    },
    placeholder: 'Search for a repository',
    minimumInputLength: 1,
    templateResult: function (e) {
      if (e.loading) return e.text;
      var t = s(
        "<div class='select2-result-repository clearfix'><div class='select2-result-repository__avatar'><img src='" +
          e.owner.avatar_url +
          "' /></div><div class='select2-result-repository__meta'><div class='select2-result-repository__title'></div><div class='select2-result-repository__description'></div><div class='select2-result-repository__statistics'><div class='select2-result-repository__forks'><i class='fa fa-flash'></i> </div><div class='select2-result-repository__stargazers'><i class='fa fa-star'></i> </div><div class='select2-result-repository__watchers'><i class='fa fa-eye'></i> </div></div></div></div>"
      );
      return (
        t.find('.select2-result-repository__title').text(e.full_name),
        t.find('.select2-result-repository__description').text(e.description),
        t.find('.select2-result-repository__forks').append(e.forks_count + ' Forks'),
        t.find('.select2-result-repository__stargazers').append(e.stargazers_count + ' Stars'),
        t.find('.select2-result-repository__watchers').append(e.watchers_count + ' Watchers'),
        t
      );
    },
    templateSelection: function (e) {
      return e.full_name || e.text;
    },
  });
};
