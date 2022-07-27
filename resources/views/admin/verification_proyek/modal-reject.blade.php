<form action="{{route('user.verification.reject')}}" method="POST">
    @csrf
    @method('PATCH')
    <div class="modal-body">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Feedback</label>
            <textarea class="form-control" name="verification_feedback" rows="3"></textarea>
        </div>

    </div>
    <div class="modal-footer">
        <a class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" href="#documentModal">Close</a>
        <input type="hidden" name="proyek_batch_id" value="{{$proyek_batch->id}}">

        <button class="btn btn-danger" type="submit">Reject</button>
    </div>
</form>