 <form class="form" id="saveNotification" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    {{-- Header --}}
    <div class="modal-header">
        <h4 class="modal-title col-12 text-center titulomodal">New Notification</h5>
    </div>
    {{-- Body --}}
    <div class="modal-body">
        <div class="bodymodal">
            <label>CATEGORIES:</label>
            <select class="form-control" id="categories_sel" name="categories_sel">
                <option value=""></option>
                @foreach($categories as $s)
                    <option value="{{$s->id}}">{{$s->name}}</option>
                @endforeach
            </select>
            <br><br>
            <label>MESSAGE:</label>
            <textarea class="form-control" id="message_tex" name="message_tex" maxlength="300" autocomplete="off"></textarea>
        </div>
    </div>
</form>
{{-- Buttons Section --}}
<div class="modal-footer">
    <button type="button" class="btn btn-success btn-sm" onclick="$('#saveNotification').submit();">SAVE</button>
    <button type="button" class="btn btn-secondary btn-sm" onclick="$('#modalnewNotification').modal('hide');">CLOSE</button>
</div>

<script>
// //////////////////////////////////////////////////////////////////////////////////////////////////////////////
$('#categories_sel').select2();
$('#categories_sel').select2({
    dropdownParent: $('#modalnewNotification'),
    placeholder: 'Categories..',
    language: {
        noResults: function(params) {
            return 'NO RESULTS';
        }
    }
});
// //////////////////////////////////////////////////////////////////////////////////////////////////////////////
$("#saveNotification").on('submit', function(e){
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: "{{route('saveNotification')}}",
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            swalLoading();
        },
        success: function(response){
            if(response.sta == 0){
                swalTimer('success','UPDATING',1000);
                $('#modalnewNotification').modal('hide');
                location.reload();
            }else{
                swalTimer('warning',response.msg,2000);
            }
        },
        error: function (error){
            swalTimer('error','HA OCURRIDO UN ERROR, INTENTALO NUEVAMENTE',2000);
        }
    });
});
// //////////////////////////////////////////////////////////////////////////////////////////////////////////////
</script>
