<section class="search">
    <div class="wrapper">
        <form action="#" method="post">
            <input type="text" id="search" name="search" placeholder="What are you looking for?" autocomplete="off"/>
            <input type="submit" id="submit_search" name="submit_search"/>
        </form>
        <a href="#" class="advanced_search_icon" id="advanced_search_btn"></a>
    </div>

    <div class="advanced_search">
        <div class="wrapper">
            <span class="arrow"></span>

            <form action="{{ route('search') }}" method="get">

                {{--<div class="input-daterange input-group" id="datepicker">--}}
                {{--<input type="text" class="input-sm form-control" name="start">--}}
                {{--<span class="input-group-addon">до</span>--}}
                {{--<input type="text" class="input-sm form-control" name="end">--}}
                {{--</div>--}}

                <div class="input-daterange search_fields" id="datepicker">
                    <input type="text" class="float" id="check_in_date" name="start_date" placeholder="Check In Date"
                           autocomplete="off">

                    <hr class="field_sep float"/>

                    <input type="text" class="float" id="check_out_date" name="end_date" placeholder="Check Out Date"
                           autocomplete="off">
                </div>

                {{--<div class="search_fields">--}}
                {{--<input type="text" class="float" id="min_price" name="min_price" placeholder="Min. Price"  autocomplete="off">--}}

                {{--<hr class="field_sep float"/>--}}

                {{--<input type="text" class="float" id="max_price" name="max_price" placeholder="Max. price"  autocomplete="off">--}}
                {{--</div>--}}
                {{--<input type="text" id="keywords" name="keywords" placeholder="Keywords"  autocomplete="off">--}}
                {{--<input type="submit" class="btn btn-primary" id="submit_search" name="submit_search" value="Search" />--}}

                <button class="btn btn-success">Search</button>
            </form>

        </div>
    </div>
</section>

<script>
    $(document).ready(function () {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = dd + '-' + mm + '-' + yyyy;

        $('.input-daterange').datepicker({
            startDate: today,
            format: 'dd-mm-yyyy',
            language: 'ru',
            clearBtn: true,
        });
    });
</script>