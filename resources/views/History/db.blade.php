@extends('Home.main')

@section('content')


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
                <th class="colcont" id="c4"></th>
                <th class="colcont" id="c5"></th>
            </tr>
            <tr>
                <th class="col" style="width: 5% !important;">#</th>
                <th class="col" style="width: 35% !important;">MESSAGE</th>
                <th class="col" style="width: 30% !important;">USER</th>
                <th class="col" style="width: 10% !important;">CATEGORY</th>
                <th class="col" style="width: 10% !important;">TYPE</th>
                <th class="col" style="width: 10% !important;">SENT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($history as $t)
                <tr>
                    <td>{{$t->id_h}}</td>
                    <td class="lefti">{{$t->id_m}} | {{$t->message}}</td>
                    <td class="lefti">{{$t->name}} | {{$t->email}} | {{$t->phone_number}}</td>
                    <td>{{$t->category}}</td>
                    <td>{{$t->type}}</td>
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
                <td class="filtercol"><input type="text" class="thfilter" idc="4" id="i4"></td>
                <td class="filtercol"><input type="text" class="thfilter" idc="5" id="i5"></td>
            </tr>
        </tfoot>
    </table>
</div>
</section>
{{-- /TABLE --}}

<script type="text/javascript">
// ///////////////////////////////////////////////////////////////////////
var c_CID = 0;
var c_MES = 1;
var c_USE = 2;
var c_CAT = 3;
var c_TYP = 4;
var c_DAT = 5;
// ///////////////////////////////////////////////////////////////////////
Dtable();
function Dtable(){
    var Dtable = $('#Dtable').DataTable({
        "sDom": "tp",
        scrollY: "480px",
        scrollX: true,
        paging: false,
        order: [[c_CID,'desc']],
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
    $('#c'+c_MES).html(numberFormat(Dtable.column(c_MES,{filter: 'applied'}).data().unique().filter(function(value, index){return value != "" ? true : false;}).count()));
    $('#c'+c_USE).html(numberFormat(Dtable.column(c_USE,{filter: 'applied'}).data().unique().filter(function(value, index){return value != "" ? true : false;}).count()));
    $('#c'+c_CAT).html(numberFormat(Dtable.column(c_CAT,{filter: 'applied'}).data().unique().filter(function(value, index){return value != "" ? true : false;}).count()));
    $('#c'+c_TYP).html(numberFormat(Dtable.column(c_TYP,{filter: 'applied'}).data().unique().filter(function(value, index){return value != "" ? true : false;}).count()));
    $('#c'+c_DAT).html(numberFormat(Dtable.column(c_DAT,{filter: 'applied'}).data().unique().filter(function(value, index){return value != "" ? true : false;}).count()));
}
// ///////////////////////////////////////////////////////////////////////
</script>
@endsection
