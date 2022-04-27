$(function () {
  var table_list;
  var language = {
    "decimal": "",
    "emptyTable": "Data tidak tersedia",
    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
    "infoFiltered": "(Difilter dari _MAX_ total data)",
    "infoPostFix": "",
    "thousands": ",",
    "lengthMenu": "Menampilkan _MENU_ data",
    "loadingRecords": "Memuat...",
    "processing": "Memproses...",
    "search": "Cari:",
    "zeroRecords": "Pencarian tidak ditemukan",
    "paginate": {
      "first": "Pertama",
      "last": "Terakhir",
      "next": "Selanjutnya",
      "previous": "Sebelumnya"
    }
  }
  var loading = `<div class="h4 text-center"><i class="fas fa-pulse fa-spinner"></i></div>`;
  var bmodal = `<div class="modal fade" data-backdrop="static" id="modal" aria-modal="true" role="dialog"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header py-2"> <h4 class="modal-title"></h4> <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button> </div> <div class="modal-body"></div> </div> </div> </div>`;
  var modalLoading = () => {
    $("#modal .modal-dialog").attr('class', 'modal-dialog modal-sm');
    $("#modal .modal-title").html(`<h5>Memuat data ...</h5>`);
    $("#modal .modal-body").html(loading);
    $("#modal").modal('show');
  }
  var loadFormModal = (url, table_list = null, type = null) => {
    modalLoading();
    $.get(url, {}, function (res) {
      if (type != null) {
        $("#modal .modal-dialog").attr('class', 'modal-dialog ' + type);
      } else {
        $("#modal .modal-dialog").attr('class', 'modal-dialog');
      }
      $("#modal .modal-title").html(res.title);
      $("#modal .modal-body").html(res.form);
      var submit = false;
      $(".modal-form").off().on('submit', function (e) {
        e.preventDefault();
        var form = $(this).serialize();
        var _this = $(this);
        var btext = _this.find('button[type=submit]').html();
        _this.find('*').prop('disabled', true);
        _this.find('button[type=submit]').text('Silahkan tunggu ...');
        if (!submit) {
          submit = true;
          $.ajax({
            url: _this.data('url'),
            type: 'post',
            dataType: 'json',
            data: form,
            success: function (res) {
              submit = false;
              toastr.remove();
              toastr.success(res.message);
              $("#modal").modal('hide');
              if (res.redirect != undefined) {
                var timeout = res.timeout != undefined ? res.timeout : 25;
                setTimeout(() => {
                  location.href = res.redirect;
                }, timeout);
              } else {
                if (table_list != null) {
                  table_list.ajax.reload();
                }
                _this.find('*').prop('disabled', false);
                _this.find('button[type=submit]').html(btext);
              }
            },
            error: function (err) {
              submit = false;
              toastr.remove();
              try {
                var errors = JSON.parse(err.responseText);
                var errMsg = errors.errors[Object.keys(errors.errors)[0]][0];
                toastr.error(errMsg);
              } catch (error) {
                toastr.error(err.responseJSON.message);
              }
              _this.find('*').prop('disabled', false);
              _this.find('button[type=submit]').html(btext);
            }
          });
        }
      });
      init(table_list);
      modalFunc();
    }, 'json').fail(function ($err) {
      $("#modal .modal-title").html("Kesalahan");
      $("#modal .modal-body").html("Tidak dapat memuat data!");
    });
  }
  var slect2 = [];
  var init = (table_list = null) => {
    if (slect2.length > 0) {
      slect2.forEach((v, i) => {
        v.select2('destroy');
      });
      slect2 = [];
    }
    $(".open-modal").off().on("click", function (e) {
      e.preventDefault();
      let type = $(this).data('type') != undefined ? $(this).data('type') : null;
      loadFormModal($(this).data('url'), table_list, type);
    });
    if ($(".select2").length > 0) {
      $(".select2").each(function () {
        var _this = $(this);
        var sl2 = $(this).off().select2({
          allowClear: _this.attr('allow-clear') == 'false' ? false : true,
          placeholder: $(this).data('placeholder') != undefined ? $(this).data('placeholder') : 'Pilih'
        });
        slect2.push(sl2);
      });
    }
    if ($(".select2-ajax").length > 0) {
      $(".select2-ajax").each(function () {
        var _this = $(this);
        var sl2 = $(this).off().select2({
          allowClear: _this.attr('allow-clear') == 'false' ? false : true,
          ajax: {
            url: _this.data('url')
          },
          minimumInputLength: _this.data('length') != undefined ? _this.data('length') : 1,
          placeholder: _this.data('placeholder') != undefined ? _this.data('placeholder') : 'Pilih'
        });
        slect2.push(sl2);
      });
    }
    if ($(".datepicker").length > 0) {
      $(".datepicker").datepicker({
        dateFormat: "dd-mm-yy",
        changeYear: true,
        changeMonth: true,
        yearRange: '1900:' + new Date().getFullYear()
      });
    }
    if ($("#study-query").length > 0) {
      formAjax($("#study-query"), $("#study-query").closest('.card').find('.card-body'));
    }
  }
  init(table_list);
  if ($("#study-query").data('role') == 'guest') {
    $("#study-query").submit();
  }
  $('body').append(bmodal);
  if ($(".table-list").length > 0) {
    $(".table-list").each(function (i, v) {
      var _url = $(this).data('url');
      var _columns = $(this).data('cols').split(',');
      var table_columns = [];
      _columns.forEach((v) => {
        var opt = v.split('!');
        var col = {};
        col.data = opt[0];
        col.name = opt[0];
        if (opt[1] != undefined) {
          opt[1].split('|').forEach((v1) => {
            if (v1 == 'order') {
              col.orderable = false;
            }
            if (v1 == 'search') {
              col.searchable = false;
            }
            if (v1 == 'visible') {
              col.visible = false;
            }
          })
        }
        table_columns.push(col);
      });
      table_list = $(this).DataTable({
        language: language,
        processing: true,
        serverSide: true,
        scrollX: true,
        autoWidth: false,
        ajax: _url != undefined ? _url : location.href,
        columns: table_columns,
        'drawCallback': function (settings) {
          init(table_list);
        }
      });
    });
  }
});
function modalFunc() {
  if ($(".table-mk-choices").length > 0) {
    $(".table-mk-choices").each(function () {
      var _row = $(this).closest(".row");
      $(this).find("tr").each(function () {
        var _tr = $(this).closest("tr");
        $(this).off().on('click', function () {
          var _tsks = Number(_row.find(".table-mk-selected .tsks").text());
          var _cb = $(this).find('input[type=checkbox]');
          var __tr = `<tr class="mk-selected" id="` + _cb.data('target').split('#')[1] + `">
                      <td class="mk">`+ _tr.find('.mk').text() + `</td>
                      <td class="smt text-center">`+ _tr.find('.smt').text() + `</td>
                      <td class="sks text-center">`+ _tr.find('.sks').text() + `</td>
                    </tr>`;
          if (!_cb.is(":checked")) {
            _cb.prop("checked", true);
            _tsks += Number(_tr.find(".sks").text());
            _row.find('.prepend').prepend(__tr);
          } else {
            _cb.prop("checked", false);
            _tsks -= Number(_tr.find(".sks").text());
            _row.find(_cb.data('target')).remove();
          }
          _row.find(".table-mk-selected .tsks").text(_tsks);
        });
      });
    });
    $("#reset-mk").off().on('click', function () {
      $(".tab-pane.show.active").find(".mk-choices").prop('checked', false);
      $(".tab-pane.show.active").find(".mk-selected").remove();
      $(".tab-pane.show.active").find(".tsks").text(0);
    });
  }
  if ($(".table-nilai").length > 0) {
    $(".table-nilai").each(function () {
      var _tl = $(this);
      $(this).find(".index").each(function () {
        changeNilai($(this), _tl);
        $(this).off().on('change', function () {
          changeNilai($(this), _tl);
        });
      });
      $(this).find(".nil").each(function () {
        setNilai($(this));
        $(this).off().on('keyup change', function () {
          setNilai($(this));
        });
      });
    });
    $("#reset-nilai").off().on('click', function () {
      $(".tab-pane.show.active").find(".index").val('').trigger('change');
    });
  }
}

function convertNilai(nilai) {
  let index = 0;
  switch (true) {
    case nilai >= 95:
      index = 4;
      break;
    case nilai >= 90 && nilai <= 94:
      index = 3.75;
      break;
    case nilai >= 85 && nilai <= 89:
      index = 3.5;
      break;
    case nilai >= 80 && nilai <= 84:
      index = 3.25;
      break;
    case nilai >= 75 && nilai <= 79:
      index = 3;
      break;
    case nilai >= 70 && nilai <= 74:
      index = 2.75;
      break;
    case nilai >= 65 && nilai <= 69:
      index = 2.5;
      break;
    case nilai >= 61 && nilai <= 64:
      index = 2.25;
      break;
    case nilai >= 55 && nilai <= 60:
      index = 2;
      break;
    case nilai >= 50 && nilai <= 54:
      index = 1;
      break;
    case nilai <= 49:
      index = 0;
      break;
  }

  return index;
}

function setNilai(dl) {
  let _val = Number(dl.val());
  let _index = dl.closest('tr').find('.index');
  let idx = convertNilai(_val);
  _index.val(idx);
  _index.trigger('change');
}
function changeNilai(dl, _tl) {
  let _val = Number(dl.val());
  let _sks = Number(dl.closest('tr').find('.sks').text());
  let _total = _val * _sks;
  dl.closest('tr').find('.total').text(_total);
  triggerNilai(_tl);
}

function triggerNilai(tbl) {
  var _totalsks = 0;
  var _totalnilai = 0;
  tbl.find('tr').each(function () {
    _totalnilai += (Number($(this).find('.sks').text()) * Number($(this).find(".index").val() != undefined ? $(this).find(".index").val() : 4));
    _totalsks += Number($(this).find(".sks").text());
  });
  var _ips = _totalnilai / _totalsks;
  tbl.find('.totalsks').text(_totalsks);
  tbl.find('.totalnilai').text(_totalnilai);
  tbl.find('.ips').text(_ips.toFixed(2));
}

function formAjax(_form, _container = null) {
  var submit = false;
  _form.off().on('submit', function (e) {
    e.preventDefault();
    var _this = $(this);
    var _data = _this.serialize();
    var _url = _this.data('url');
    var _method = _this.attr('method');
    var btext = _this.find('button[type=submit]').html();
    _this.find('*').prop('disabled', true);
    _this.find('button[type=submit]').text('Silahkan tunggu ...');
    var _bcontainer = _container.html();
    if (_container != null) {
      _container.html('<h4 class="text-center"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Memuat data ...</h4>');
    }
    if (!submit) {
      submit = true;
      $.ajax({
        url: _url,
        type: _method,
        dataType: 'json',
        data: _data,
        success: function (res) {
          submit = false;
          _this.find('*').prop('disabled', false);
          _this.find('button[type=submit]').html(btext);
          if (res.message != undefined) {
            toastr.remove();
            toastr.success(res.message);
          }
          if (res.view != undefined && _container != null) {
            _container.html(res.view);
            formAjaxPost(_form, res);
          }
        },
        error: function (err) {
          submit = false;
          toastr.remove();
          try {
            var errors = JSON.parse(err.responseText);
            var errMsg = errors.errors[Object.keys(errors.errors)[0]][0];
            toastr.error(errMsg);
          } catch (error) {
            if (err.responseJSON.message != undefined) {
              toastr.error(err.responseJSON.message);
            }
          }
          _this.find('*').prop('disabled', false);
          _this.find('button[type=submit]').html(btext);
          _container.html(_bcontainer);
        }
      });
    }
  });
}
function formAjaxPost(_form = null, res = null) {
  if ($(".dtable").length > 0) {
    $(".dtable").DataTable({
      scrollX: true
    });
  }
}