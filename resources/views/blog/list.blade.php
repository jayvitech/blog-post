@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="container">
                    <div class="table-responsive">
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                {!! \Session::get('success') !!}
                            </div>
                        @endif

                        <h3>Blog List</h3>
                        <div>
                            <label for="">Created At</label>
                            <input type='text' class="form-control datepicker" id="datepicker" />
                            <button type="button" class="btn" onclick="callFilterDate()">Submit</button>
                        </div>
                        <a class="btn btn-primary float-right" href="{{ url('blog/add') }}">
                            Add Blog
                        </a>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Author Name</th>
                                <th>Title</th>
                                <th>Category</th>
                            </tr>
                            </thead>
                            <tbody class="user_table">
                            @foreach($blogData as $key => $blog)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$blog['name']}}</td>
                                    <td>{{$blog['title']}}</td>
                                    @php
                                        $category = '';
                                        $idsArr = explode(',',$blog['blog_category_id']);
                                        $categoryData = \App\Blog_category::whereIn('id',$idsArr)->get();
                                        if(count($categoryData) > 0) {
                                            foreach ($categoryData as $value) {
                                                $category .= $value->name .', ';
                                            }
                                            $category = rtrim($category, ', ');
                                        }
                                    @endphp
                                    <td>{{$category}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/jquery.min.js') }}" defer></script>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script type="text/javascript">
        $( function() {
            $('.datepicker').datepicker({
                format: 'Y-m-d'
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function callFilterDate() {
            var date = $('#datepicker').val();
            $.ajax({
                type: 'GET',
                url: '/call-filter/' + date,
                success: function (data) {
                    $(".user_table").html(data);
                }
            });
        }
    </script>
@endsection
