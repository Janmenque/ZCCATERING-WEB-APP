<script>
    function confirm_action()
    {
        return confirm('Are you sure you want to take this action?');
    }
</script>
<script type="text/javascript">
      
    $(".update-cart").change(function (e) {
        e.preventDefault();
  
        var ele = $(this);
  
        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}', 
                id: ele.parents("tr").attr("data-id"), 
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });
  
    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
  
        var ele = $(this);
  
        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
  
</script>
<script type="text/javascript" src="{{ url('public/plugin/daterangepicker') }}/moment.js"></script>
  <script type="text/javascript" src="{{ url('public/plugin/daterangepicker') }}/daterangepicker.js"></script>
  <script>
    $(function() {

      $('input[name="drange"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
          cancelLabel: 'Clear'
        }
      });

      $('input[name="drange"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
      });

      $('input[name="drange"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
      });

    });
  </script>

<script type="text/javascript">
  function add_to_cart(id)
  {
    $.ajax
    ({
    type:'post',
    url:"{{ route('add.to.cart') }}",
    data:{
     id:id
    },
    success:function(response) {
    if(response=="success")
    {
      alert('Item added to cart')
      refresh_cart();
      refresh_cart_pos();
    }
    else
    {
      alert(response);
    }
    }
    });
   
  
   return false;
  }
  </script>

<script>
  function refresh_cart() {
    var xmlhttp;
    if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var res = xmlhttp.responseText;
          document.getElementById("cart_div").innerHTML = res;
      }
    }
    xmlhttp.open("GET", "{{ route('refresh_cart') }}", true);
    xmlhttp.send();
  }

  function refresh_cart_pos() {
    var xmlhttp;
    if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var res = xmlhttp.responseText;
          document.getElementById("cart").innerHTML = res;
      }
    }
    xmlhttp.open("GET", "{{ route('refresh_cart_pos') }}", true);
    xmlhttp.send();
  }
</script>