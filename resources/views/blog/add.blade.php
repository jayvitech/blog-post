@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mx-auto">
                <h3 class="login-heading mb-4 text-center">Blog</h3>
                <form action="{{url('post-blog')}}" method="POST" id="blogForm">
                    @csrf
                    <div class="form-group row">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control" placeholder="title" value="{{ old('title') }}" required>
                        @if ($errors->has('title'))
                            <span class="error">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label for="category">Select Category</label>
                        <select name="category[]" class="form-control" multiple="multiple" required>
                            @foreach($categoryData as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Description" rows="5" cols="5" required>{{ old('title') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="error">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="form-group row mb-0">
                        <button type="submit" class="btn btn-primary btn-block">Post Blog</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection