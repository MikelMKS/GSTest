@extends('Home.main')

@section('content')
{{-- HEAD --}}
<h5 class="card-title">
    <button type="button" class="btn btn-success" onclick="newNotification()">New Notification</button>
    <span class="colvisBut"></span>
</h5>
<p></p>
{{-- /HEAD --}}


{{-- TABLE --}}
<section class="section profile">
<div class="row">
    <table id="Dtable" class="styled-table" style="width:100%">
        <thead>
            <tr>
                <th class="colcont" id="c0"></th>
                <th class="colcont" id="c1"></th>
                <th class="colcont" id="c2"></th>
                <th class="colcont" id="c3"></th>
            </tr>
            <tr>
                <th class="col" style="width: 5% !important;">ID</th>
                <th class="col" style="width: 30% !important;">CATEGORIES</th>
                <th class="col" style="width: 50% !important;">MESSAGE</th>
                <th class="col" style="width: 15% !important;">CREATED AT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notifications as $t)
                <tr>
                    <td class="drillin" onclick="notificationDetails('{{$t->id}}')">{{$t->id}}</td>
                    <td>{{$t->id_category}}</td>
                    <td class="lefti">{{$t->message}}</td>
                    <td>{{dateFormat($t->created_at)}}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="filtercol"><input type="text" class="thfilter" idc="0" id="i0"></td>
                <td class="filtercol"><input type="text" class="thfilter" idc="1" id="i1"></td>
                <td class="filtercol"><input type="text" class="thfilter" idc="2" id="i2"></td>
                <td class="filtercol"><input type="text" class="thfilter" idc="3" id="i3"></td>
            </tr>
        </tfoot>
    </table>
</div>
</section>
{{-- /TABLE --}}

{{-- MODELS --}}
{{--  --}}
<div class="modal fade" id="modalnewNotification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            {{--  --}}
            <div id="modalnewNotificationBody">

            </div>
            {{--  --}}
        </div>
    </div>
</div>
{{--  --}}
{{-- /MODELS --}}

<script type="text/javascript">
// ///////////////////////////////////////////////////////////////////////
var c_CID = 0;
var c_CAT = 1;
var c_MES = 2;
var c_DAT = 3;
// ///////////////////////////////////////////////////////////////////////
Dtable();
function Dtable(){
    var Dtable = $('#Dtable').DataTable({
        "sDom": "tp",
        scrollY: "450px",
        scrollX: true,
        paging: false,
        "language": {
            "sProcessing": "Processing...",
            "sZeroRecords": "No results found.",
            "sEmptyTable": "No data available in this table.",
        },
    })

    counter(Dtable);

    $('.thfilter').on('keyup change blur',function () {let idc = this.getAttribute("idc");Dtable.columns(idc).search( this.value ).draw();counter(Dtable);});
}

function counter(Dtable) {
    $('#c'+c_CID).html(numberFormat(Dtable.column(c_CID,{filter: 'applied'}).data().filter(function(value, index){return value != "" ? true : false;}).count()));
    $('#c'+c_CAT).html(numberFormat(Dtable.column(c_CAT,{filter: 'applied'}).data().unique().filter(function(value, index){return value != "" ? true : false;}).count()));
    $('#c'+c_MES).html(numberFormat(Dtable.column(c_MES,{filter: 'applied'}).data().unique().filter(function(value, index){return value != "" ? true : false;}).count()));
    $('#c'+c_DAT).html(numberFormat(Dtable.column(c_DAT,{filter: 'applied'}).data().unique().filter(function(value, index){return value != "" ? true : false;}).count()));
}
// ///////////////////////////////////////////////////////////////////////
function newNotification(){
    $.ajax({
        data: { _token: "{{ csrf_token() }}" },
        type : "GET",
        url : "{{route('newNotification')}}",
        beforeSend : function () {
            $("#modalnewNotificationBody").html('{{Html::image('img/loading.gif', 'CARGANDO ESPERE', ['class' => 'center-block'])}}');
        },
        success:  function (response) {
            $('#modalnewNotification').modal({backdrop: 'static',keyboard: false});
            $('#modalnewNotification').modal('show');
            $("#modalnewNotificationBody").html(response);
        },
        error: function(error) {
            swalTimer('error','N ERROR HAS OCCURRED, PLEASE TRY AGAIN',2000);
        }
    });
}
// ///////////////////////////////////////////////////////////////////////
</script>
@endsection
