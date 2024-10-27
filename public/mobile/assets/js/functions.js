var BASE_URL = $('body').data('url');

var TEXT_SUCCESS = 'text-success';
var TEXT_PRIMARY = 'text-primary';
var TEXT_SECUNDARY = 'text-secundary';
var TEXT_INFO = 'text-info';
var TEXT_WARNING = 'text-warning';
var TEXT_DANGER = 'text-danger';

var ICON_SUCCESS = 'fa-check';
var ICON_SAVE = 'fa-save';
var ICON_INFO = 'fa-info';
var ICON_MINUS = 'fa-minus';
var ICON_LOADING = 'fa-spinner fa-spin';
var ICON_WARNING = 'fa-triangle-exclamation';
var ICON_ERROR = 'fa-times';

var LOCALE = {
    "format": "DD/MM/YYYY",
    "separator": " - ",
    "applyLabel": "Aplicar",
    "cancelLabel": "Cancelar",
    "fromLabel": "De",
    "toLabel": "Até",
    "customRangeLabel": "Custom",
    "daysOfWeek": [
        "Dom",
        "Seg",
        "Ter",
        "Qua",
        "Qui",
        "Sex",
        "Sáb"
    ],
    "monthNames": [
        "Janeiro",
        "Fevereiro",
        "Março",
        "Abril",
        "Maio",
        "Junho",
        "Julho",
        "Agosto",
        "Setembro",
        "Outubro",
        "Novembro",
        "Dezembro"
    ],
    "firstDay": 0
};

$.each( $('form').find('select'), function( keyInput, select ) {
    var value = $(select).attr('data-selected');
    if (value != '' && value != undefined) {
        $(select).val(value).trigger('change');
    }
});

/**
 * Verifica se o valor é vazio
 */

StrPad = (str, max) => {
    if (str == null) {
        str = 0;
    }
    str = str.toString();
    return str.length < max ? StrPad("0" + str, max) : str;
}

/**
 * Verifica se o valor é vazio
 */
function empty(value) {
    if (value === '' || value == '' || value == null || typeof value === "undefined") {
        return true;
    }
    return false;
}

function in_array(needle, haystack) {
    var found = 0;
    for (var i = 0, len = haystack.length; i < len; i++) {
        if (haystack[i] == needle) return i;
        found++;
    }
    return -1;
}
function number_format(number, decimals, dec_point, thousands_sep) {
    number = parseFloat(number);
    number = (number.toFixed(decimals) + '')
        .replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return String((n * k) / k);
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
        .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    return s.join(dec);
}

function money_format(number) {
    if (empty(number)) {
        return '0,00';
    }
    var value = number.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2});

    return value;
}
function format_number(number) {
    if (empty(number)) {
        return 0;
    }
    if (String(number).indexOf(',') == -1) {
        return parseFloat(number);
    }
    var value = parseFloat(String(number).replace('.', '').replace(',', '.'));
    if (isNaN(value)) {
        return 0;
    }
    return value;
}

function date_format(date) {
    var date = new Date(date);
    return date.toLocaleDateString('pt-BR');
}

function limpa_numeros(string) {
    return string.replace(/\D/g, '');
}
function remove_especial(string) {
    return string.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,'');
}
function slugify(str) {
    if (empty(str)) {
        return str;
    }
    // Remove qualquer caractere em branco do final do texto:
    str = str.replace(/^\s+|\s+$/g, '');

    // Lista de caracteres especiais que serão substituídos:
    const from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_-,:;";

    // Lista de caracteres que serão adicionados em relação aos anteriores:
    const to   = "aaaaaeeeeeiiiiooooouuuunc       ";

    // Substitui todos os caracteres especiais:
    for (let i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    // Remove qualquer caractere inválido que possa ter sobrado no texto:
    str = str.replace(/[^a-z0-9 -]/g, '');

    // Substitui os espaços em branco por hífen:
    str = str.replace(/\s+/g, '');

    return str;
}

/**
* classe ".fn-show" ao elemento que sofre a alteração
* data-show no item que sofre a alteração
*/
$(document).on('change', ".fn-show", function () {
    var $element = $(this);
    var showElement = '';
    var elementValue = '';

    // Para Select, Checkbox ou Radio
    if($element.is('select')) {
        showElement = $element.attr('name');
        elementValue = $element.find('option:selected').val();
    } else if ($element.is(':checkbox') || $element.is(':radio')){
        if ($element.is(':checked')) {
            showElement = $element.attr('name');
            elementValue = $element.val();
        } else { // :Radio
            showElement = $element.attr('name');
            elementValue = 'undefined';
        }
    } else {
        showElement = $element.attr('name');
        elementValue = $element.val();
    }

    $('[data-show*='+showElement+']').each(function(index, value){
        if ($(value).is('[data-show~='+showElement+'-'+elementValue+']')){
            $(value).removeClass('d-none').attr('disabled', false);

            if ($(value).parent().is('select')){
                if ($(value).is(':selected')){
                    $(value).parent().val($(value).parent().children(':not(.d-none):first').val()).click().change();
                }

                var $divSelect = $(value).closest('.bootstrap-select');

                $divSelect.find('ul').find('a:nth('+$(value).index()+')').parent().removeAttr('disabled');
            }
        } else {
            $(value).addClass('d-none').attr('disabled', true);

            if ($(value).parent().is('select')){
                if ($(value).is(':selected')){
                    $(value).parent().val($(value).parent().children(':not(.d-none):first').val()).click().change();
                }

                var $divSelect = $(value).closest('.bootstrap-select');

                $divSelect.find('ul').find('a:nth('+$(value).index()+')').parent().attr('disabled', true);
            }
        }
    });
});

$(document).on('change', ".fn-enable", function () {
    var $element = $(this).closest('form');
    if (!$element.length) {
        $element = $element.closest('#kt_app_content_container');
    }

    var input = $element.val();
    var value = $(this).attr('data-value') + "";
    var element = $(this).attr('data-element');
    var $item = $('[name='+element+'], [data-enable='+element+']');

    var bloqueia = false;
    var values = value.split(',');

    if ($element.is('input[type=checkbox]')) {
        if ($element.is(':checked')) {
            bloqueia = false;
        } else {
            bloqueia = true;
        }
    } else {
        if (value.length > 0){
            values.forEach(function(val){
                if (input == val) {
                    bloqueia = true;
                }
            });
        } else {
            if (input == value) {
                bloqueia = true;
            }
        }
    }

    $.each($item, function (value, element){
        var invert = $(element).hasClass('invertEnable');
        if (invert) {
            if (bloqueia) {
                if ($(element).is('input')) {
                    $(element).removeAttr('readonly');
                } else {
                    $(element).removeClass('disabled');
                }
            } else {
                if ($(element).is('input')) {
                    $(element).attr('readonly', true);
                } else {
                    $(element).addClass('disabled');
                }
            }
        } else {
            if (bloqueia) {
                if ($(element).is('input')) {
                    $(element).attr('readonly', true);
                } else {
                    $(element).addClass('disabled');
                }
            } else {
                if ($(element).is('input')) {
                    $(element).removeAttr('readonly');
                } else {
                    $(element).removeClass('disabled');
                }
            }
        }
    });
});

/*
 *   ---------- enableChechbox ----------
 */
$(document).on('change', '.fn-enableChechbox',  function () {
    var input = $(this).attr('data-input');
    var value = $(this).attr('data-value');

    if ($(this).is(":checked") == true) {
        $('#'+input).removeAttr('disabled').val(value);
    } else {
        $('#'+input).attr('disabled', true).val(value);
    }
});

/* EXIBE E OCULTA VALUE DO CAMPO */
$(document).on('click', '.fn-passHide',  function () {
    var $botao = $(this);
    var $icon = $botao.children('i');

    if ($icon.hasClass('fa-eye')) {
        $icon.removeClass('fa-eye').addClass('fa-eye-slash');
        $botao.siblings('input').removeAttr('type', 'password').attr('type', 'text');
    } else if ($icon.hasClass('fa-eye-slash')) {
        $icon.removeClass('fa-eye-slash').addClass('fa-eye');
        $botao.siblings('input').removeAttr('type', 'text').attr('type', 'password');
    }
});

/* EXIBE E OCULTA VALUE DO CAMPO */
$(document).on('click', '.fn-passEdit',  function () {
    var $botao = $(this);
    var $input = $botao.siblings('input');

    if ($input.prop('disabled')) {
        $input.removeAttr('disabled');
    } else {
        $input.attr('disabled', true);
    }
});

$(document).on('click', '.fn-rand',  function () {
    var $input = $(this).parent().parent().parent().find('.rand');
    var pre = $input.attr('data-pre');
    var max = 10000000000;
    var codigo = Math.floor(Math.random() * max + 1);

    $input.val(pre + '-' + codigo);
});
FormSelect = function () {
    $.each($('.content-page').find('select'), function(keyInput, select) {
        var value = $(select).attr('data-select');

        if (value != undefined && value != '') {
            $(select).val(value);
        }
    });
}
FormSelect();


$(document).on('click', '.fn-remover', function () {
    var $form = $(this);
    var id = $form.data('id');
    var method = $form.data('method');
    var content = $form.data('content');

    Swal.fire({
        html: 'Realmente deseja remover o(a): <b>' + content + '</b>',
        icon: "warning",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "<i class='fad fa-circle-check'></i> Confirmar",
        cancelButtonText: "<i class='fad fa-circle-xmark'></i> Cancelar",
        customClass: {
            confirmButton: "btn btn-success py-2 me-2",
            cancelButton: 'btn btn-danger py-2'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: BASE_URL + '/' + method + '/delete',
                type: 'POST',
                data: {'id': id},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                timeout: 5000,
                beforeSend:function () {
                    toastr.info("Removendo, aguarde...");
                },
                error: function () {
                    toastr.clear()
                    toastr.warning("Erro ao remover registro.");
                    return false;
                },
                success: function (response) {
                    toastr.clear()
                    if (response.success) {
                        toastr.success("Registro removido com sucesso!");
                    } else {
                        erros = jQuery.parseJSON(response.erro);
                        toastr.warning("Erro ao remover registro: " + response.erro);
                    }
                }
            });
        }
    });
});

$(document).on('blur', ".fn-cep", function(){
    var cep = $(this).val();
    cep = cep.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,'');

    if (!empty(cep)) {
        $.ajax({
            url: BASE_URL + '/cep/' + cep,
            method: 'get',
            error: function () {
                toastr.error("Erro ao consultar CEP!");
            },
            success: function (data) {
                response = data.item;
                if (data.success) {
                    $('input[name=logradouro]').val(response.logradouro);
                    $('input[name=bairro]').val(response.bairro);
                    $('input[name=cidade]').val(response.localidade);
                    $('input[name=codigo_ibge]').val(response.ibge);
                    $('input[name=uf]').val(response.uf);
                } else {
                    toastr.warning("CEP não encontrado e/ou incorreto!");
                }
            }
        });
    }
});

$(document).on('click', '.vibrar', function () {
    window.navigator.vibrate(100);
});

$(".money").maskMoney({thousands:'.', decimal:',', allowZero:true, suffix: ''});

ToggleFullScreen = function () {
    if ((document.fullScreenElement && document.fullScreenElement !== null) ||
        (!document.mozFullScreen && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        }
        $('#full-screen').removeClass('fa-expand').addClass('fa-compress');
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
        $('#full-screen').removeClass('fa-compress').addClass('fa-expand');
    }
}
