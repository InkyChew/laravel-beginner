<!-- Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Sure to delete {{$Merchandise->name}} ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <form action="/merchandise/{{ $Merchandise->id }}/delete" method="POST">
              {{ method_field('DELETE') }}
              {{ csrf_field() }}
              <input type="submit" class="btn btn-danger" value="Delete"/>
        </form>
      </div>
    </div>
  </div>
</div>