@extends('pathologist.layouts.admin-layout')
@section('title', 'SUPER ADMINS - SWATHGRAM')
@section('content')

<section class="section show-section satellite_data mt-3">
    <div class="container">
        <div class="row mt-5">
            <table id="satellite_data_table" class="table table-striped pt-2">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>NO. OF TEST</th>
                        <th>Total Tests</th>
                        <th>TOTAL TESTS</th>
                        <th>NO. OF QC</th>
                        <th>TOTAL QC</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>LAB9999AH9999</td>
                        <td>ACC/ML/99999</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="test-map-details mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Device ID: </label>
                                </div>
                                <div class="col-md-8">
                                    LAB0123AN0123
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Registration: </label>
                                </div>
                                <div class="col-md-8">
                                    09/09/2016 11:01:30 AM
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Organization: </label>
                                </div>
                                <div class="col-md-8">
                                    Accuster Technologies Pvt. Ltd.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">TOTAL NO. OF TEST: </label>
                                </div>
                                <div class="col-md-8">
                                    01234
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Mobile Number: </label>
                                </div>
                                <div class="col-md-8">
                                    9876543210
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">TOTAL NO. OF QC TEST: </label>
                                </div>
                                <div class="col-md-8">
                                    98765
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Description: </label>
                                </div>
                                <div class="col-md-8">
                                    Accukine+Satellite_QCC
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Address: </label>
                                </div>
                                <div class="col-md-8">
                                    37 ASMD,C/O 56 APO,Udhampur,Jammu & Kashmir-182101
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="map-title">
                        <h3>Live Location</h2>
                    </div>
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
  #map {
    height: 380px; /* or any appropriate height */
    width: 100%;
  }
</style>
@endsection

@section('custom-js')
<script>
    $(document).ready(function() {
        $('#satellite_data_table').DataTable({
            "ordering": false,
            "searching": false,
            "paging": false,
            "info": false,
        });
    });

    function deleteLabTechnician(satellite_dataId)
    {
        swal({
            title: "Are you sure You want to Delete It ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelClient) =>
        {
            if (willDelClient)
            {
                $.ajax({
                    type: "POST",
                    url: '{{ route("pathologist.satellite_data.delete") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': satellite_dataId,
                    },
                    dataType: 'JSON',
                    success: function(response)
                    {
                        if (response.success == 1){
                            swal(response.message, {
                                icon: "success",
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1200);
                        }else{
                            swal(response.message, {
                                icon: "error",
                            });
                        }
                    }
                });
            }
            else
            {
                swal("Cancelled", "", "error");
            }
        });
    }
</script>


<script type="text/javascript">
    function initMap() {

        const myLatLng = { lat: 22.2734719, lng: 70.7512559 };

        const map = new google.maps.Map(document.getElementById("map"), {

        zoom: 5,

        center: myLatLng,

        });



        new google.maps.Marker({

        position: myLatLng,

        map,

        title: "Hello Rajkot!",

        });

    }
    window.initMap = initMap;
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqxVoIgNj3kP1uw5UCp9wUh8R5_7SWdbQ&callback=initMap">
</script>
@endsection