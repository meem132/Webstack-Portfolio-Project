<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- CK Editor -->
<script src="bower_components/ckeditor/ckeditor.js"></script>
<!-- Magnify -->
<script src="magnify/magnify.min.js"></script>

<script>
  $(function () {
    // DataTable initialization
    $('#example1').DataTable();
    // CK Editor initialization
    CKEDITOR.replace('editor1');

    // Magnify initialization
    $('.zoom').magnify();

    // Focus event for search input
    $('#navbar-search-input').focus(function(){
      $('#searchBtn').show();
    });

    // Focusout event for search input
    $('#navbar-search-input').focusout(function(){
      $('#searchBtn').hide();
    });

    // Submit event for product form
    $('#productForm').submit(function(e){
      e.preventDefault();
      var product = $(this).serialize();
      $.ajax({
        type: 'POST',
        url: 'cart_add.php',
        data: product,
        dataType: 'json',
        success: function(response){
          $('#callout').show();
          $('.message').html(response.message);
          if(response.error){
            $('#callout').removeClass('callout-success').addClass('callout-danger');
          }
          else{
            $('#callout').removeClass('callout-danger').addClass('callout-success');
            getCart();
          }
        }
      });
    });

    // Click event for close button
    $(document).on('click', '.close', function(){
      $('#callout').hide();
    });

    // Function to fetch cart items
    function getCart(){
      $.ajax({
        type: 'POST',
        url: 'cart_fetch.php',
        dataType: 'json',
        success: function(response){
          $('#cart_menu').html(response.list);
          $('.cart_count').html(response.count);
        }
      });
    }

    // Initial call to fetch cart items
    getCart();
  });
</script>
