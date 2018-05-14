{{include "header-clean"}}

<style>
  .tabulator-frozen {
    background: white !important;
  }
</style>

<div class="overlay-header">
  <a href="{{config.directory}}" class="header-item">Back to main site</a>
  <a href="{{config.directory}}/admin/logout" class="header-item">Logout</a>
</div>

<div class="container pt-2">
  <div class="row">
    <div class="col"> 
      <div class="text-center pb-4">
        <h3 class="text-center">Registrations</h3>
        <small class="text-muted">Registration requests for the conference.</small>
          {{message}}
      </div>
      <div class="text-center py-3">
        <a href="/kdrmii/report/emailExcel" target="_blank" class="btn btn-info mx-1">emailExcel.xls</a>
        <a href="/kdrmii/report/peopleExcel" target="_blank" class="btn btn-info mx-1">peopleExcel.xls</a>
        <a href="/kdrmii/report/abstractword" target="_blank" class="btn btn-info mx-1">abstractword.doc</a>
        <a href="/kdrmii/report/diplomaword" target="_blank" class="btn btn-info mx-1">diplomaword.doc</a>
      </div>
      <div id="users-table-body"></div>
      <div class="text-right pt-3">
        <button class="btn btn-danger" id="discardButton" onClick="discardChanges()">Cancel</button>
        <button class="btn btn-success" id="saveButton" onClick="saveChanges()">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
    crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tabulator/3.5.1/js/tabulator.min.js"></script>
<script>
  var currentEditingId;

  var users = {{users}};
  var initialUsers = JSON.stringify(users);
  $('#saveButton').hide();
  $('#discardButton').hide();
  $(function() {
    //create Tabulator on DOM element
    $("#users-table-body").tabulator({
      height:'65vh', // set height of table (in CSS or here), this enables the Virtual DOM and improves render speed dramatically (can be any valid css height value)
      layout:"fitDataFill",
      columns:[ //Define Table Columns
        { title: 'ID', field: 'id' },
        { title: 'Email', field: 'email', editor: true, editable: isEditable },
        // { title: 'Password', field: 'password', editor: true, editable: isEditable },
        { title: 'Institution', field: 'institution', editor: true, editable: isEditable },
        { title: 'Degree', field: 'degree', editor: true, editable: isEditable },
        { title: 'First name', field: 'first_name', editor: true, editable: isEditable },
        { title: 'Last name', field: 'last_name', editor: true, editable: isEditable },
        { title: 'Affiliation', field: 'affiliation', editor: true, editable: isEditable },
        { title: 'Phone number', field: 'phone_number', editor: true, editable: isEditable },
        { title: 'Article title', field: 'article_title', editor: true, editable: isEditable },
        { title: 'Article authors', field: 'article_authors', editor: true, editable: isEditable },
        { title: 'Article authors affiliations', field: 'article_authors_affiliations', editor: true, editable: isEditable },
        { title: 'Hotel', field: 'hotel', editor: true, editable: isEditable },
        { title: 'Leading people', field: 'leading_people', editor: true, editable: isEditable },
        { title: 'Abstract', field: 'abstract', editor: true, editable: isEditable },
        { title: 'Additional events', field: 'additional_events', editor: true, editable: isEditable },
        { formatter:"buttonCross", width:30, align:"center", frozen: true, headerSort:false, cellClick: deleteUser }
        // { title: 'Validated', field: 'validated', editor: true, editable: isEditable }
      ],
      cellEdited: function(cell){
        onCellEdited(cell)
      },
      cellClick:function(e, cell){
        e.preventDefault();
        return false;
        //e - the click event object
        //cell - cell component
      },
    });
    $("#users-table-body").tabulator("setData", users);
  })

  var deleteUser = function(ev, cell) {
    console.log(cell);
    
    let id = cell.getRow().getData().id;
    if(confirm("Are you sure you want to delete?")) {
      var f = document.createElement("form");
      $(f).attr('action', '{{config.directory}}/admin/delete/' + id);
      $(f).attr('method', 'POST'); 
      $(document.body).append(f);
      $(f).submit();
    }
  }

  var isEditable = function(cell){
    var data = cell.getRow().getData();
    var editable = (currentEditingId == null) || (data.id == currentEditingId);
    return !!editable;
  }

  function onCellEdited(cell) {
    var id = cell.cell.row.cells[0].value;
    if(usersDataChanged(users)) {
      currentEditingId = id;
    } else {
      currentEditingId = null;
    }
  }

  function usersDataChanged(users) {
    let changed = JSON.stringify(users) != initialUsers;
    if(changed) {
      $('#saveButton').show();
      $('#discardButton').show();
    } else {
      $('#saveButton').hide();
      $('#discardButton').hide();
    }
    return changed;
  }

  function discardChanges() {
    users = JSON.parse(initialUsers);
    $("#users-table-body").tabulator("setData", users);
    currentEditingId = null;
    usersDataChanged(users);
  }

  function saveChanges() {
    var f = document.createElement("form");
    $(f).attr('action', '{{config.directory}}/admin/update/' + currentEditingId);
    $(f).attr('method', 'POST'); 
    var row = users.find(function(el) { return el.id == currentEditingId});
    if(!row) return;
    for(var key in row) {
      $(f).append($("<input>").attr("type", "hidden").attr("name", key).val(row[key]));
    }
    $(document.body).append(f);
    $(f).submit();
  }

</script>

{{include "footer-clean"}}
