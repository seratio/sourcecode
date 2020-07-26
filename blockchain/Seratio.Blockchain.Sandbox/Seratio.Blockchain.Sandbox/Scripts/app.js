/// <reference path="jquery-1.10.2.intellisense.js" />
var WebApp = {
    Init: function () {
        WebApp.Plugins.Init();
        WebApp.Events.Init();
    },
    Data: {
        DataTable: null,
    },
    Plugins: {
        Init: function () {
            WebApp.Plugins.PrepareDataTables();
            WebApp.Plugins.ActivateMiscOnDemandPlugins();
            WebApp.Plugins.PrepareDateRange();
        },
        PrepareDataTables: function () {
            $('.data-table').each(function (index, table) {
                WebApp.Data.DataTable = $(table).DataTable({
                    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                    "oLanguage": {
                        "sLengthMenu": '<span class="hide">Show:</span> _MENU_',
                        "sSearch": '<span class="hide">Search:</span> _INPUT_',
                        "oPaginate": {
                            "sNext": '&rarr;',
                            "sLast": 'Last',
                            "sFirst": 'First',
                            "sPrevious": '&larr;'
                        }
                    },
                    responsive: true,
                    "bProcessing": true,
                    "bServerSide": true,
                    "bFilter": true,
                    "scrollX": true,
                    "bPaginate": true,
                    "aaSorting": [
                        [$(table).attr('data-key'), 'asc']
                    ],
                    "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": ["no-sort"]
                    }],
                    "aLengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "sAjaxSource": function () {
                        return $(table).attr('data-source')
                    }(),
                    "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        switch ($(table).attr('data-type')) {
                            case 'statusPopover':
                                break;
                            default:
                                break;
                        }
                    },
                    fnDrawCallback: function (oSettings) {

                    }
                });
            }),
                $("#recipient").typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 1,
                    source: function (request, response) {
                        $.ajax({
                            url: '/wallet/se/requests/AutoComplete/',
                            data: "{ 'q': '" + request + "'}",
                            dataType: "json",
                            type: "POST",
                            contentType: "application/json; charset=utf-8",
                            success: function (data) {
                                items = [];
                                map = {};
                                $.each(data, function (i, item) {
                                    var _id = item.id;
                                    var _text = item.text;
                                    map[_text] = { id: _id, text: _text };
                                    items.push(_text);
                                });
                                response(items);
                                $(".dropdown-menu").css("height", "auto");
                            },
                            error: function (response) {
                                alert(response.responseText);
                            },
                            failure: function (response) {
                                alert(response.responseText);
                            }
                        });
                    },
                    updater: function (item) {
                        $('#receiver').val(map[item].id);
                        return item;
                    },
                    matcher: function (item) {
                        return true;
                    }
                });
        },
        PrepareDateRange: function () {
            $('.date-range').each(function (index, input) {
                $(input).daterangepicker({
                    locale: {
                        format: 'MM/DD/YYYY'
                    },
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                        'Last 7 Days': [moment().subtract('days', 6), moment()],
                        'Last 30 Days': [moment().subtract('days', 29), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                    },
                    autoUpdateInput: false
                }, function (start, end) {
                    switch ($(input).attr('data-type')) {
                        default:
                            break;
                    }
                    $(input).val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
                });

                $(input).parent().find('.input-group-btn').click(function () {
                    $(input).trigger('click')
                })
            });
        },
        ActivateMiscOnDemandPlugins: function () {
            $('.timepicker').livequery(function () {
                $(this).timepicker({
                    timeFormat: 'h:mm p',
                    interval: 10,
                    defaultTime: $(this).attr('data-final'),
                    startTime: '09:00',
                    dynamic: false,
                    dropdown: true,
                    scrollbar: true
                });
            });
        }
    },
    Events: {
        Init: function () {
            WebApp.Events.BindStaticEvents();
            WebApp.Events.BindLiveEvents();
        },
        BindStaticEvents: function () {
            $(document)
                .on('click',
                    '.confirm',
                    function () {
                        return confirm($(this).attr('data-confirm'));
                    })
                .on('submit', '.retail-policy-form', function () {
                    if ($('#PolicyType').val() == 'Coin' && ($('#RequiredCoinID').val() == '' || $('#RequiredCoinID').val() == undefined)) {
                        alert('Please select a coin.');
                        return false;
                    } else {
                        return true;
                    }
                })
                .on('submit',
                    '.frm',
                    function () {
                        var amount = $("#amount").val();
                        var coin = $("#CoinID :selected").text();
                        var recipient = $(".recipient").val();

                        var value = confirm('You are sending ' + amount + ' ' + coin + ' to ' + recipient + '. Are you sure you want to proceed?');
                        if (value == true) {
                            $(".txsubmit").attr("disabled", "disabled");
                        }
                        else {
                            return false;
                        }
                    })
                .on('submit',
                    '.pay_form',
                    function () {
                        var amount = $("#amount").text();
                        var recipient = $("#to").text();

                        var value = confirm('You are sending ' + amount + ' to ' + recipient + '. Are you sure you want to proceed?');
                        if (value == true) {
                            $(".txsubmit").attr("disabled", "disabled");
                        }
                        else {
                            return false;
                        }
                    })
                .on('submit',
                    '.frm_deposit',
                    function () {
                        var amount = $("#amount").val();
                        var coin = $("#CoinID :selected").text();
                        var _duration = $("#Duration").val();

                        if (_duration == "0") {
                            _duration = "Custom Amount of Time";
                        } else {
                            _duration += " Month(s)";
                        }

                        var value = confirm('You are locking ' + amount + ' ' + coin + ' for ' + _duration + '. The lock-in cannot be reversed once confirmed. Are you sure you want to proceed?');
                        if (value == true) {
                            $(".txsubmit").attr("disabled", "disabled");
                        }
                        else {
                            return false;
                        }
                    })
                .on('submit',
                    '.frm_limit',
                    function () {

                        var value = confirm('Are you sure you want to update the Vault Capacity?');
                        if (value == true) {
                            $(".txsubmit").attr("disabled", "disabled");
                        }
                        else {
                            return false;
                        }
                    })
                .on('submit',
                    '.frm_claim',
                    function () {
                        var value = confirm('Are you sure you want to proceed with the Claim?');
                        if (value == true) {
                            $(".txsubmit").attr("disabled", "disabled");
                        }
                        else {
                            return false;
                        }
                    })
                .on('change',
                    '.Criteria',
                    function () {

                        if ($("#Criteria").val() != "") {
                            $(".CriteriaValueDiv").removeClass("hidden");
                            $("#AssetTransactionCriteriaValue").attr("data-val", "true");
                            $("#AssetTransactionCriteriaValue").attr("data-val-required",
                                "Please enter a value for Asset Transaction Criteria Value");

                            //$('.form-group').livequery(function () {
                            //    if ($(this).find('input[data-val-required],textarea[data-val-required],textarea[data-val-summernote]').not('[type="checkbox"]').length < 1) {
                            //        alert("df")
                            //        $(this).find('label').first().append('<span class="text-danger">&nbsp;*</span>');
                            //    }
                            //});
                        } else {
                            $(".CriteriaValueDiv").addClass("hidden");
                            $("#AssetTransactionCriteriaValue").removeAttr("data-val");
                            $("#AssetTransactionCriteriaValue").removeAttr("data-val-required");
                        }
                        WebApp.Core.RebindFormValidation();
                    })
                .on('change keyup',
                    '#currentanswer',
                    function () {
                        if ($("#currentanswer").val() != "") {
                            $(".answer").val($("#currentanswer").val());
                            //$("#ans").val($("#currentanswer").val());
                            //$("#wallans").val($("#currentanswer").val());

                        } else {
                            $(".answer").val($("#currentanswer").val());
                            //$("#ans").val($("#currentanswer").val());s
                            //$("#wallans").val($("#currentanswer").val());

                        }
                        WebApp.Core.RebindFormValidation();
                    })
                .on('click',
                    '#activity',
                    function () {
                        $.post("/wallet/rewardingbody/default/GetCoinDetails/",
                            { activityId: $(this).val() },
                            function (data) {
                                if (data != null) {
                                    $('#coinname').val(data.coinName);
                                    $('#RewardedCoinID').val(data.coinID);
                                    $('#RewardedAmount').val(data.Amount);

                                    $.get('/wallet/wallets/seratiowallet/GetCoinInfo',
                                        {
                                            ID: data.coinID
                                        },
                                        function (data) {
                                            if (data != null) {
                                                $("#gas").closest('.row').show();
                                                $("#gas").slider('destroy');
                                                $("#gas").val(data.GasPrice);

                                                $("#gas").slider({
                                                    value: data.GasPrice,
                                                    ticks: [data.SafeGasPrice, data.GasPrice, data.FastGasPrice],
                                                    ticks_labels: [
                                                        data.SafeGasPrice + ' Gwei (Safe Low)', data.GasPrice + ' Gwei (Standard)',
                                                        data.FastGasPrice + ' Gwei (Fast)'
                                                    ],
                                                    step: 1
                                                });
                                            }
                                        });
                                }
                            });
                    })
                .on('change keyup',
                    '#BillAmount',
                    function () {

                        var _policyID = $("#policy").val();

                        if (_policyID == null) {
                            var value = confirm('Please Select a policy first');
                            if (value == true) {
                                $('#BillAmount').val('');
                                window.location.href = '/wallet/retailend/default/';
                            } else {
                                window.location.href = '/wallet/retailend/default/';
                            }
                        }
                        if ($(this).val() == null || $(this).val() == "") {

                            $('#Discount').val("");
                            $('#NetAmount').val("");
                        }
                        $.post("/wallet/retailend/default/GetDiscount/",
                            { policyID: _policyID, billAmount: $(this).val() },
                            function (data) {
                                if (data != null) {

                                    $('#Discount').val(data.discount);
                                    $('#NetAmount').val(data.netamount);
                                }
                            });
                    })
                .on('click',
                    '#policy',
                    function () {

                        var _policyID = $(this).val();
                        var _billAmount = _policyID = $('#BillAmount').val();

                        if (_billAmount != null) {

                            $.post("/wallet/retailend/default/GetDiscount/",
                                { policyID: $(this).val(), billAmount: _billAmount },
                                function (data) {
                                    if (data != null) {

                                        $('#Discount').val(data.discount);
                                        $('#NetAmount').val(data.netamount);
                                    }
                                });
                        }


                    })
                .on('click',
                    '#download-qr',
                    function () {
                        var _data = $('#image').attr('src');
                        $(this).attr('download', 'QR Code.jpg')
                        $(this).attr('href', _data)
                    })
                .on('change',
                    '#PolicyType',
                    function () {
                        if ($('#PolicyType').val() == "SE") {
                            $('.scorecriteria').removeAttr("hidden");
                            $('.coincriteria').attr("hidden", "hidden");

                            //$('#MinSESCore').attr("data-val", "true");
                            //$('#MinSESCore').attr("data-val-required", "Please enter the Minumum SE score");
                            //$('#MaxSEScore').attr("data-val", "true");
                            //$('#MaxSEScore').attr("data-val-required", "Please enter the MAximum SE score");

                        } else {
                            $('.scorecriteria').attr("hidden", "hidden");
                            $('.coincriteria').removeAttr("hidden");

                            //$('#MinSESCore').removeAttr("data-val");
                            //$('#MinSESCore').removeAttr("data-val-required");
                            //$('#MaxSEScore').removeAttr("data-val");
                            //$('#MaxSEScore').removeAttr("data-val-required");

                        }
                    })
                .on('change',
                    '#CoinID',
                    function () {
                        $.get('/wallet/wallets/seratiowallet/GetCoinInfo',
                            {
                                ID: $(this).val()
                            },
                            function (data) {
                                if (data != null) {
                                    $("#gas").closest('div').show();
                                    $("#gas").slider('destroy');
                                    $("#gas").val(data.GasPrice);
                                    $('#coin_selector_holder').find('img.coin-icon').remove();
                                    $('#coin_selector_holder')
                                        .append('<img src="/wallet/uploads/' +
                                            data.Icon +
                                            '" class="coin-icon" style="width: 50px;height: auto;margin-top: 20px;" />');
                                    $("#gas").slider({
                                        value: data.GasPrice,
                                        ticks: [data.SafeGasPrice, data.GasPrice, data.FastGasPrice],
                                        ticks_labels: [
                                            data.SafeGasPrice + ' Gwei (Safe Low)', data.GasPrice + ' Gwei (Standard)',
                                            data.FastGasPrice + ' Gwei (Fast)'
                                        ],
                                        step: 1
                                    });
                                }
                            });

                    })
                .on('change', '#Duration', function () {
                    if ($(this).val() == '0') {
                        $('#seconds_container').show();
                        $('#seconds').focus();
                    } else {
                        $('#seconds_container').hide();
                        $('#seconds').val('');
                    }
                }).on('change', '#type', function () {
                    if ($(this).val() == 'partial') {
                        $('#amount_container').show();
                        $('#amount').focus();
                    } else {
                        $('#amount_container').hide();
                        $('#amount').val('');
                    }
                });
        },
        BindLiveEvents: function () {
            $('#pay_gas').livequery(function () {
                var _coinID = $(this).attr('data-coin');
                $.get('/wallet/wallets/seratiowallet/GetCoinInfo',
                    {
                        ID: _coinID
                    },
                    function (data) {
                        if (data != null) {
                            $("#pay_gas").closest('.form-group').show();
                            $("#pay_gas").val(data.GasPrice);

                            $("#pay_gas").slider({
                                value: data.GasPrice,
                                ticks: [data.SafeGasPrice, data.GasPrice, data.FastGasPrice],
                                ticks_labels: [
                                    data.SafeGasPrice + ' Gwei (Safe Low)', data.GasPrice + ' Gwei (Standard)',
                                    data.FastGasPrice + ' Gwei (Fast)'
                                ],
                                step: 1
                            });
                        }
                    });
            });
            $('select').not('.dataTables_length select').livequery(function () {
                $(this).select2();
                $(this).trigger('change');
            });
            $('select.auto-select').livequery(function () {
                $(this).val($(this).attr('data-selected'));
            });
            $('.data-table').livequery(function () {
                $('.dataTables_filter input[type=search]').attr('placeholder', 'Search');
                $('.dataTables_length select').addClass('form-control');
            });
            $('select.form-select').livequery(function () {
                $(this).select2();
            });
            $('.styled').livequery(function () {
                $(this).uniform({ radioClass: 'choice' });
            });
            $('.file-styled').livequery(function () {
                $(this).uniform({
                    fileButtonHtml: '<i class="icon-upload"></i>',
                    wrapperClass: 'bg-primary'
                });
            });
            $('.html-editor').livequery(function () {
                $(this).summernote({
                    height: 150
                });
            });

            $('.toggle-switch').livequery(function () {
                $(this).bootstrapToggle({
                    on: 'Yes',
                    off: 'No'
                });
            });
            $('[data-toggle="popover"]').livequery(function () {
                $(this).popover();
            });
            $('.bootstrap-slider').livequery(function () {
                $(this).slider({
                    formatter: function (value) {
                        return 'Current value: ' + value;
                    }
                });
            });

            $('#qr_reader').livequery(function () {
                $(this).html5_qrcode(function (data) {
                    $('#qr_data').val(data);
                    $("form").submit();
                }, function (error) {
                    $('#qr_read_status').html(error);
                }, function (videoError) {
                    $('#qr_read_status').html(videoError);
                });
            });


            $('.tooltipster').livequery(function () {
                $(this).tooltipster();
            });

            $('#_reader').livequery(function () {
                $(this).html5_qrcode(function (data) {
                    $.post("/wallet/users/GetUser/",
                        {
                            token: data
                        }, function (data) {
                            if (data != null) {
                                $('#WalletAddress').val(data.WalletAddress);
                                $('#qr_user_img').attr('src', '/wallet/assets/images/avatar.jpg');
                            }
                            else {
                                $('#WalletAddress').val('');
                                $('#qr_user_img').attr('src', '/wallet/assets/images/avatar_unknown.png');
                            }
                        });
                }, function (error) {
                    $('#qr_read_status').html(error);
                }, function (videoError) {
                    $('#qr_read_status').html(videoError);
                });
            });


            $('input.datepicker,input.pickadate').livequery(function () {
                var _options = {};

                _options.todayHighlight = true;
                _options.autoclose = true;

                if ($(this).attr('data-min') != null) {
                    _options.startDate = $(this).attr('data-min');
                }

                if ($(this).attr('data-max') != null) {
                    _options.endDate = $(this).attr('data-max');
                }

                if ($(this).is('.hidden-previous')) {
                    _options.startDate = new Date();
                }

                $(this).datepicker(_options);
            });
            $('input.autocomplete').livequery(function () {
                $(this).removeClass('autocomplete');
                var source = $(this).attr('data-source');
                var multiple = $(this).attr('data-multiple') == 'true' ? true : false;
                $(this).select2({
                    multiple: multiple,
                    minimumInputLength: 0,
                    allowClear: true,
                    ajax: {
                        quietMillis: 150,
                        url: function () {

                            return source;
                        },
                        dataType: 'json',
                        data: function (term, page) {
                            return {
                                i: page,
                                q: term
                            }; ch
                        },

                        results: function (data, page) {
                            var _hasMoreResults = (page * 20) < data.Total;
                            return {
                                results: data.Results,
                                more: _hasMoreResults
                            };
                        }
                    }
                });

                var deafult = $(this).attr('data-select2-default');

                if (typeof deafult !== typeof undefined && deafult !== false) {
                    var _item = $.parseJSON($(this).attr('data-select2-default'));
                    $(this).select2('data', _item);
                }
            });
            $('.form-group').livequery(function () {
                if ($(this).find('input[data-val-required],textarea[data-val-required],textarea[data-val-summernote],select[data-val-required]').not('[type="checkbox"]').length > 0) {
                    $(this).find('label').first().append('<span class="text-danger">&nbsp;*</span>');
                }
            });
        }
    },
    Core: {
        RebindFormValidation: function () {
            $("form")
                .removeData("validator")
                .removeData("unobtrusiveValidation");

            $.validator
                .unobtrusive
                .parse("form");
        },
        GetNumber: function (val) {
            val = parseFloat(val);

            if (isNaN(val)) {
                return 0;
            }
            else {
                return val;
            }
        },
        ProcessNames: function () {
            function SetAttributes(index, item) {

                $(item).find('input, textarea, select').attr('id', function (i, attr) {
                    if (attr != undefined) {
                        var name = attr.split('.')[1];
                        var prefix = attr.split('[')[0];

                        return prefix + '[' + index + '].' + attr.split('.')[1]
                    }
                });

                $(item).find('select').attr('name', function (i, attr) {
                    if (attr != undefined) {
                        var name = attr.split('.')[1];
                        var prefix = attr.split('[')[0];

                        return prefix + '[' + index + '].' + attr.split('.')[1]
                    }
                });

                $(item).find('input, textarea').attr('name', function (i, attr) {
                    if (attr != undefined) {
                        var name = attr.split('.')[1];
                        var prefix = attr.split('[')[0];

                        return prefix + '[' + index + '].' + attr.split('.')[1]
                    }
                });

                $(item).find('input, text').attr('name', function (i, attr) {
                    if (attr != undefined) {
                        var name = attr.split('.')[1];
                        var prefix = attr.split('[')[0];

                        return prefix + '[' + index + '].' + attr.split('.')[1]
                    }
                });

                $(item).find('span.field-validation-valid').attr('data-valmsg-for', function (i, attr) {
                    if (attr != undefined) {
                        var name = attr.split('.')[1];
                        var prefix = attr.split('[')[0];

                        return prefix + '[' + index + '].' + attr.split('.')[1]
                    }
                });

                $(item).find('span.text-danger').attr('data-valmsg-for', function (i, attr) {
                    if (attr != undefined) {
                        var name = attr.split('.')[1];
                        var prefix = attr.split('[')[0];

                        return prefix + '[' + index + '].' + attr.split('.')[1]
                    }
                });

                $(item).find('select2-offscreen').attr('name', function (i, attr) {
                    if (attr != undefined) {
                        var name = attr.split('.')[1];
                        var prefix = attr.split('[')[0];

                        return prefix + '[' + index + '].' + attr.split('.')[1]
                    }
                });
            }

            $('.duplicatable-form-fields').each(function (index, item) {
                SetAttributes(index, item);
            });
            $('.add-more-item').each(function (index, item) {
                SetAttributes(index, item);
            });
        },
        HighlightCurrentMenuItem: function (item, index) {
            var _matches = $('.main-menu > li > ul > li > a:contains(' + item + ')');

            var _link = null;

            if (_matches.length > 0) {
                $(_matches).each(function () {
                    _link = $(this).closest('.has-sub-menu');
                });
            }

            if (_link != null) {
                _link.addClass('active');
            }
        },
        ProcessTableValidation: function (item) {
            item.find("input[type='text']").each(function () {
                $(this).rules("add", {
                    required: true
                });
            });
        },
        CheckForTransactionStatus: function () {
            setInterval(function () {
                $.get('/wallet/wallets/seratiowallet/GetStatus',
                    function (response) {
                        if (response != null && response != "" && response.length > 0) {
                            WebApp.Notifications.Show('Success', response);
                        }
                    });
            }, 5000);
        }
    },
    Notifications: {
        Show: function (_type, _msg) {
            switch ((_type)) {
                case 'Error':
                    toastr.error(_msg, 'Error')
                    break;
                case 'Success':
                    toastr.success(_msg, 'Success')
                    break;
                case 'Info':
                    toastr.info(_msg, 'Info')
                    break;
            }
        }
    }
}

$(document).ready(function () {
    WebApp.Init();
    //$('data-mask').mask('00/00/0000 00:00:00');
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-center",
        "onclick": null,
        "showDuration": "6000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "10000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",

    }
    //  $('#reader').html5_qrcode(function (data) {
    //      alert("asd")
    //      alert(data)
    //      $('#qr_reader').val(data);
    //      $("form").submit()

    //      //$.post("/Autologinall/", { token: data  },

    //      //                    function (data) {
    //      //                    //    if (data != null) {
    //      //                    //        currentItem.find('td:eq(3) span.stock_availability').text((data.Availability).toFixed(3));
    //      //                    //        currentItem.find('td:eq(4) input.Unitprice').val((data.Price).toFixed(3));
    //      //                    //    }
    //      //}
    //      //                    );

    //  },
    //    function (error) {
    //        $('#read_error').html(error);
    //    }, function (videoError) {
    //        $('#vid_error').html(videoError);
    //    }
    //);
});