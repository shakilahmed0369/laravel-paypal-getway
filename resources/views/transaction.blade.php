<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Test</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

  </head>
  <body>
    @if(\Session::has('error'))
        <div class="alert alert-danger">{{ \Session::get('error') }}</div>
        {{ \Session::forget('error') }}
    @endif
    @if(\Session::has('success'))
        <div class="alert alert-success">{{ \Session::get('success') }}</div>
        {{ \Session::forget('success') }}
    @endif

    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="mt-5 mb-3">Laravel Form</h3>
                    <form action="{{ route('processTransaction') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label>Name</label>
                            <div><input type="text" name="name" class="form-control box-quantity"></div>
                            <small class="text-danger" id="name"></small>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <div><input type="text" name="email" class="form-control box-quantity"></div>
                            <small class="text-danger" id="email"></small>

                        </div>
                        <div class="mb-3">
                            <label>Amount to pay (in USD)</label>
                            <div>
                                <select name="amount" class="form-control box-quantity">
                                    <option value="5">$5</option>
                                    <option value="10">$10</option>
                                </select>
                                <small class="text-danger" id="amount"></small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_SANDBOX_CLIENT_ID') }}"></script>

    <script>
        // submit form via ajax
        $('form').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = '{{ route('paymentValidation') }}';
            var method = form.attr('method');
            var data = form.serialize();
            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    if(response.status == 'success') {
                        form.unbind('submit').submit();
                    }
                },
                error: function(error) {
                   // show error on ids
                     var errors = error.responseJSON.errors;
                        errors.email ? $('#email').html(errors.email[0]) : $('#email').html('');
                        errors.name ? $('#name').html(errors.name[0]) : $('#name').html('');
                        errors.amount ? $('#amount').html(errors.amount[0]) : $('#amount').html('');
                }
            });
        });
    </script>

  </body>
</html>


