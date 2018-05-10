{{include "header-clean"}}

<div class="overlay-header">
  <a href="{{config.directory}}" class="header-item">Back to main site</a>
  <a href="{{config.directory}}/admin/login" class="header-item">Logout</a>
</div>

<div class="container pt-2">
  <div class="row">
    <div class="col"> 
      <div class="text-center pb-4">
        <h3 class="text-center">Registrations</h3>
        <small class="text-muted">Registration requests for the conference.</small>
      </div>
      <div id="users-table-body"></div>
    </div>
  </div>
</div>

<script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
    integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
    crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tabulator/3.5.1/js/tabulator.min.js"></script>

<script>
  var users = {{users}};

  $(function() {
    //create Tabulator on DOM element
    $("#users-table-body").tabulator({
      height:'80vh', // set height of table (in CSS or here), this enables the Virtual DOM and improves render speed dramatically (can be any valid css height value)
      layout:"fitColumns", //fit columns to width of table (optional)
      columns:[ //Define Table Columns
        { title: 'First name', field: 'first_name' },
        { title: 'Last name', field: 'last_name' },
        { title: 'Institution', field: 'institution' },
        { title: 'Affiliation', field: 'affiliation' },
        { title: 'Email', field: 'email' },
        { title: 'Phone mumber', field: 'phone_number' },
        { title: 'Article title', field: 'article_title' },
        { title: 'Article authors', field: 'article_authors' },
        { title: 'Article authors affiliations', field: 'article_authors_affiliations' }
      ],
      rowClick:function(e, row){ //trigger an alert message when the row is clicked
          alert("Row " + row.getData().id + " Clicked!!!!");
      },
    });
    $("#users-table-body").tabulator("setData", users);
  })


</script>

{{include "footer-clean"}}
