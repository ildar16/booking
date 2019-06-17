@if($apartment)
    <div class="container">
        <h1>
            {{ $apartment->title }}
        </h1>
        <div class="col-md-6">

            @if($apartment->img)
                @foreach($apartment->img as $img)
                    <img src="{{ asset('apartments_img/'. $apartment->alias . '/' . $img) }}"
                         alt="" title=""
                         class="property_img"/>
                @endforeach
            @else
                <img src="/{{ config('settings.theme') . "/img/no_image.png" }}" alt="no_image" class="property_img"/>
            @endif
        </div>
        <div class="col-md-5">
            <h4 style="margin-top: 0px;">${{ $apartment->price }}</h4>
            <form action="{{ route("book.create", ['alias' => $apartment->alias]) }}" method="post">
                <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="input-sm form-control" name="book_start">
                    <span class="input-group-addon">до</span>
                    <input type="text" class="input-sm form-control" name="book_end">
                </div>
                <input type="submit" class="btn btn-success" value="Book">
                @csrf
            </form>
            <hr>

        </div>

        <div class="col-md-9">
            <h6>{{ $apartment->text }}</h6>
            @if ($comforts)
                <ul class="list-group">
                    <li class="list-group-item active">Удобства</li>
                    @foreach($comforts as $comfort)
                        <li class="list-group-item">{{ $comfort->com_name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>
@endif

<script>
    $(document).ready(function () {

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        sd = new Date(yyyy + '-' + mm + '-' + dd);

        tomorrow = parseInt(dd) + 1 + '-' + mm + '-' + yyyy;

        var enabledDates = {!! json_encode($dates) !!};
        var userBooks = {!! json_encode($userBooks) !!};
        var pattern = /(\d{2})\-(\d{2})\-(\d{4})/;

        $('#datepicker').datepicker({
            startDate: today,
            format: 'dd-mm-yyyy',
            language: 'ru',
            clearBtn: true,
            enableOnReadonly: true,
            datesDisabled: enabledDates
        });

        for (var i = 0; i < enabledDates.length; i++) {
            if ((new Date(enabledDates[i].replace(pattern, '$3-$2-$1'))).getTime() == sd.getTime()) {
                sd = new Date(sd.setDate(sd.getDate() + 1));

            }
        }

        $(".form-control").on('click', function (event) {
            var date;
            for (var i = 0; i < userBooks.length; i++) {
                date = (new Date(userBooks[i].replace(pattern, '$3-$2-$1'))).getTime();
                $("td[data-date=" + (new Date(userBooks[i].replace(pattern, '$3-$2-$1'))).getTime() + "]").addClass('today').attr('tooltip', 'It is your book');
            }
        });

        $('input[name=book_start]').datepicker('setDates', sd);


    });
</script>


