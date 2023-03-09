@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Beers</div>

                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>ABV</th>
                                    <th>IBU</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($beers as $beer)
                                    <tr>
                                        <td>{{ $beer->name }}</td>
                                        <td>{{ $beer->description }}</td>
                                        <td>{{ $beer->abv }}</td>
                                        <td>{{ $beer->ibu }}</td>
                                        <td><img src="{{ $beer->image_url }}" alt="{{ $beer->name }}" width="100"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                              @for($idx = 0; $idx < $qtyPages; $idx++)
                                <li class="page-item"><a class="page-link" href="?page={{ $idx }}">{{ $idx + 1 }}</a></li>
                              @endfor
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection