<a class="btn btn-danger" data-dismiss="modal" data-toggle="modal" href="#rejectModal">Reject</a>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<form action="{{route('user.verification.accept')}}" method="POST">
    @csrf
    @method('PATCH')
    <input type="hidden" name="proyek_batch_id" value="{{$proyek_batch->id}}">
    <button type="submit" class="btn btn-success">Accept</button>
</form>
