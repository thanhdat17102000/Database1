<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
    a {
        text-decoration: none;
    }

    .flex {}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>

    <div class="card">
        <div class="card-header h3 pt-3 pb-3 bg-info text-white">Quản lý sản phẩm</div>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{session('success')}}
        </div>
        @endif
        @if(session('noti'))
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
            {{session('noti')}}
        </div>
        @endif
        @if( isset($data['handle']) && $data['handle'] === "loadFormEdit" )
        <form action="{{ route('product.update',$data['productDetail']['id']) }}" method="POST"
            enctype="multipart/form-data" class="mt-3">
            @csrf
            <input type="hidden" name="_method" value="put" />
            <input type="hidden" name="imageCurrent" value="{{$data['productDetail']['image']}}" />
            <div class="card">
                <div class="card-header text-center text-white bg-info h4">Chỉnh sửa sản phẩm</div>
                <div class="card-body ml-5 mr-5">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Tên sảm phẩm</label>
                                <input type="text" class="form-control" placeholder="" name="title"
                                    value="{{$data['productDetail']['title']}}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="">Giá :</label>
                                <input type="number" class="form-control" placeholder="" name="price"
                                    value="{{$data['productDetail']['price']}}">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="">Số lượng :</label>
                                <input type="number" class="form-control" placeholder="" id="" name="quantity"
                                    value="{{$data['productDetail']['quantity']}}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Trạng thái :</label>
                                <select class="form-control" placeholder="" id="" name="status">
                                    <option value="pending"
                                        {{ $data['productDetail']['status'] === "pending" ? "selected" : "" }}>Đang chờ
                                    </option>
                                    <option value="approve"
                                        {{ $data['productDetail']['status'] === "approve" ? "selected" : "" }}>Đã duyệt
                                    </option>
                                    <option value="reject"
                                        {{ $data['productDetail']['status'] === "reject" ? "selected" : "" }}>Từ chối
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <img src="{{URL::asset('/uploads/'.$data['productDetail']['image'])}}" alt="" height="auto"
                                width="350" class="ml-5">
                        </div>
                        <div class="col-4">
                            <div class="form-group mt-5">
                                <label for="">Hình ảnh mới: </label>
                                <input type="file" class="form-control" placeholder="" name="fileToUpload">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Mô tả</label>
                                <textarea type="text" class="form-control" placeholder="" name="description"
                                    rows="6">{{$data['productDetail']['quantity']}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer ">
                    <button type="submit" class="btn btn-info">Lưu thông tin</button>
                    <a href="{{ route('product.index') }}" type="button" class="btn btn-danger"
                        data-dismiss="modal">Quay lại trang chủ</a>
                </div>
            </div>
        </form>
        @else
        <div class="card-body">
            <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#exampleModal">
                Thêm sản phẩm
            </button>

            <div class="clearfix mt-3">
                <div class="float-left">
                    <div class="h4">Lọc sản phẩm theo trạng thái :</div>
                    <a href="{{URL::to('product/')}}" class="btn btn-info mt-3">Tất cả ({{$data['all']}})</a>
                    <a href="{{URL::to('product/?status=pending')}}" class="btn btn-primary mt-3">Đang chờ ({{$data['pending']}})</a>
                    <a href="{{URL::to('product/?status=approve')}}" class="btn btn-success mt-3">Đã duyệt ({{$data['approve']}})</a>
                    <a href="{{URL::to('product/?status=reject')}}" class="btn btn-danger mt-3">Từ chối ({{$data['reject']}})</a>
                </div>
                <div class="float-right">
                    <div class="h4">Tìm kiếm theo tên sản phẩm :</div>
                    <form action="{{URL::to('product')}}" class="form-inline" method="GET">
                        <input type="text" class="form-control" placeholder="Tìm kiếm tên sản phẩm ..." name="search">
                        <button type="submit" class="btn btn-primary ml-3">Tìm kiếm</button>
                    </form>
                </div>
            </div>

            <form class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                action="{{route("product.store")}}" method="POST" aria-hidden="true" enctype="multipart/form-data"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm sản phẩm</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Tên sảm phẩm</label>
                                <input type="text" class="form-control" placeholder="" name="title">
                            </div>
                            <div class="form-group">
                                <label for="">Giá :</label>
                                <input type="number" class="form-control" placeholder="" name="price">
                            </div>
                            <div class="form-group">
                                <label for="">Hình ảnh</label>
                                <input type="file" class="form-control" placeholder="" name="fileToUpload">
                            </div>
                            <div class="form-group">
                                <label for="">Số lượng</label>
                                <input type="number" class="form-control" placeholder="" id="" name="quantity">
                            </div>
                            <div class="form-group">
                                <label for="">Mô tả</label>
                                <textarea type="text" class="form-control" placeholder="" name="description"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Hình ảnh</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Mô tả</th>
                        <th>Trạng thái</th>
                        <th>Thời gian</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['productList'] as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->title}}</td>
                        <td><img src="{{URL::asset('/uploads/'.$item['image'])}}" height="auto" width="200px"></td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->description}}</td>
                        <td>
                            {{$item->status === 'pending' ? 'Đang chờ' : ''}}
                            {{$item->status === 'approve' ? 'Đã duyệt' : ''}}
                            {{$item->status === 'reject' ? 'Từ chối' : ''}}
                        </td>
                        <td>

                            <b>Thời gian đăng</b> : {{$item->created_at}}
                            <br>
                            <b>Thời gian cập nhật</b> :
                            {{strtotime($item->updated_at) === strtotime($item->created_at) ? "Chưa cập nhật" : $item->updated_at}}
                        </td>
                        <td class="h4">
                            <a href="{{route('product.edit',$item->id)}}" class="ml-3"><i
                                    class="fa-solid fa-pen"></i></a>
                            <a href="{{url('/product/delete',['id' => $item->id])}}" class="ml-3 text-danger"><i
                                    class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $data['productList']->links() }}
        </div>
        @endif
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
