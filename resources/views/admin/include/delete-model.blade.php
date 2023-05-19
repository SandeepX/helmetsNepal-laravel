<div class="modal fade" id="deleteModel" tabindex="-1" aria-labelledby="deleteModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="exampleModalLabel">Delete </h5>
                <p>Are you sure?</p>
            </div>
            <div class="modal-body">
                {!! Form::open(['method'=>'DELETE','class'=>'get_link']) !!}
                    <button class="btn btn-primary continue-btn ">Delete</button>
                    <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
