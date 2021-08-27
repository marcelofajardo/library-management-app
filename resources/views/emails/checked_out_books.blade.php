<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header ui-sortable-handle">
                    <h1 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        Book Lending Details
                    </h1>
                </div>
                <!-- /.card-header -->
                <div class="card-body py-2">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tr><td colspan="2"><h3>Dear {{ $lendings[0]['user']['name'] }}, you have taken out the following:</h3></td></tr>
                            @foreach ($lendings as $data)
                                <tr height="15px">
                                    <td>Title:</td>
                                    <td>{{ $data['book_copy']['book']['title'] }}</td>
                                </tr>
                                <tr>
                                    <td>Author:</td>
                                    <td>{{ $data['book_copy']['book']['author']['name'] }}</td>                                </tr>
                                <tr>
                                    <td>Publication date:</td>
                                    <td>{{ $data['book_copy']['publication_date']->format('d.m.Y.') }}</td>
                                </tr>
                                <tr>
                                    <td>Deadline:</td>
                                    <td>{{ $data['deadline']->format('d.m.Y.') }}</td>
                                </tr>
                                <tr height="15px"></tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <p>Please mind the relevant deadlines and keep the books intact! Fines are to be paid in case of damage or lateness.</p>
                    <p>Thank you for your cooperation and understanding.</p>
                    <h3>UniLib</h3>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
<body>