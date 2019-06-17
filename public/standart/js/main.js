$(document).ready(function () {

    /*  Hamburger Menu & Icon  */
    $('.hamburger').on('click', function (e) {

        e.preventDefault();
        $(this).toggleClass('opned');
        $('header nav').toggleClass('active');

    });

    /*  Advanced search form & Icon  */
    $('#advanced_search_btn').on("click", function (e) {
        e.preventDefault();
        var ads_box = $('.advanced_search');
        if (!ads_box.hasClass('advanced_displayed')) {
            $(this).addClass('active');
            ads_box.stop().fadeIn(200).addClass('advanced_displayed');
        } else {
            $(this).removeClass('active');
            ads_box.stop().fadeOut(200).removeClass('advanced_displayed');
        }
    });

    var input = $("#images");
    var close = $(".close");

    function showUploadedItem(source) {
        var list = document.getElementById("image-list"),
            li = document.createElement("li"),
            img = document.createElement("img");
        img.src = source;
        li.appendChild(img);
        list.appendChild(li);
    }

    function readURL(input) {

        if (input.files && input.files[0]) {

            for (var i = 0; i < input.files.length; i++) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    showUploadedItem(e.target.result)
                }
                reader.readAsDataURL(input.files[i]);
            }


        }
    }

    input.change(function (e) {
        readURL(this);
    });

    $('#image-list').on('click', 'li', function () {
        var img_names = $(this).data("name");

        console.log($('ul#image-list li').length)

        if ($('ul#image-list li').length == 1) {
            $(this).addClass('list-group-item-danger').attr('tooltip', "You can't remove last image!");
            return false;
        }
        $(this).remove();
//            $("#delete").val($("#delete").val() + img_names + "|");

        $('<input>').attr({
            type: 'hidden',
            id: 'delete',
            name: 'delete[]',
            value: img_names
        }).appendTo('form');

    });

    function translite(string) {
        var dictionary = {
            'а': 'a',
            'б': 'b',
            'в': 'v',
            'г': 'g',
            'д': 'd',
            'е': 'e',
            'ж': 'g',
            'з': 'z',
            'и': 'i',
            'й': 'y',
            'к': 'k',
            'л': 'l',
            'м': 'm',
            'н': 'n',
            'о': 'o',
            'п': 'p',
            'р': 'r',
            'с': 's',
            'т': 't',
            'у': 'u',
            'ф': 'f',
            'ы': 'i',
            'э': 'e',
            'А': 'A',
            'Б': 'B',
            'В': 'V',
            'Г': 'G',
            'Д': 'D',
            'Е': 'E',
            'Ж': 'G',
            'З': 'Z',
            'И': 'I',
            'Й': 'Y',
            'К': 'K',
            'Л': 'L',
            'М': 'M',
            'Н': 'N',
            'О': 'O',
            'П': 'P',
            'Р': 'R',
            'С': 'S',
            'Т': 'T',
            'У': 'U',
            'Ф': 'F',
            'Ы': 'I',
            'Э': 'E',
            'ё': 'yo',
            'х': 'h',
            'ц': 'ts',
            'ч': 'ch',
            'ш': 'sh',
            'щ': 'shch',
            'ъ': '',
            'ь': '',
            'ю': 'yu',
            'я': 'ya',
            ' ': '-'
        };

        return string.toLowerCase().trim().replace(/[\s\S]/g, function (x) {
            if (dictionary.hasOwnProperty(x))
                return dictionary[x];
            return x;
        }).replace(/[^a-zA-Z0-9-]/g, '');
    };

    $("#title").bind("input change", function () {
        $("#alias").val(translite($("#title").val()));
    });

    function loadMoreData(page) {
        $.ajax({
            url: page,
            type: "get",
            beforeSend: function () {
                $('.ajax-load').show();
                $('.more_listing').hide();
            }
        }).done(function (data) {
            if (data.html == " ") {
                $('.ajax-load').html("No more records found");
                return;
            }

            if (data == 'empty') {
                $('.more_listing').text('Showed all apartments...');
            }

            $('.ajax-load').hide();
            $('.more_listing').show();
            $("#post-data").append(data.html);

        }).fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('server not responding...');
        });
    }

    var page = 1;

    $(".more_listing_btn").click(function () {
        page++;
        var url = new URL(window.location.href);
        url.searchParams.append('page', page);
        loadMoreData(url.pathname + url.search);
    });


    $('.user-status').change(function () {
        var user_id = $(this).attr('data-id');
        var status = $(this).val();
        var select = $(this);

        var data = {status: status, user_id: user_id};
        var url = '/admin_area/user/ups';
        var message = "User status changed";

        ajaxFunction(select, data, url, message);
    });

    $('.apartment-status').change(function () {
        var apart = $(this).attr('data-alias');
        var status = $(this).val();
        var select = $(this);

        var data = {status: status};
        var url = '/admin_area/apartment/ups/' + apart;
        var message = "Apartment status changed";

        ajaxFunction(select, data, url, message);
    });

    function ajaxFunction(select, data, url, message) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            async: true,
            beforeSend: function () {
                select.css('background-color', '#eee');
            },
            complete: function () {
                select.css('background-color', 'white');
            },
            url: url,
            data: data,
            success: function (data) {
                $.notify({
                    message: message
                }, {
                    type: 'warning'
                });
            }
        });
    }

});