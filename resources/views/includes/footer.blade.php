<!-- Modal -->
<div class="modal fade" id="advertisementModal" tabindex="-1" aria-labelledby="advertisementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="advertisementModalLabel">Select Advertisement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{url('first-submitted-form-listing')}}" method="get">
                    <div class="mb-3">
                        <select name="advertisement" class="form-control form-select" aria-label="Select Advertisement" id="select_Advertisement">
                            @foreach($advertisements as $advertisement)
                            <option value="{{$advertisement['id']}}">{{$advertisement['advertisement_name']}} -- {{$advertisement['advertisement_number']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<footer class="container">
    <p class="text-center pt-3 pb-3">&copy; Copyright PMIU Data Center. All Rights Reserved</p>
</footer>
@php
    $postIds = session('postIds', []);
    @endphp
@if(auth()->check())
<script>
    @if(count($postIds) == 0)
    $(document).ready(function() {
        $('#advertisementModal').modal('show');
    });
    @endif
</script>
@endif
</main>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('assets/dist/js/jquery-3.2.1.slim.min.js') }}"></script>
<script src="{{ asset('assets/dist/js/popper.min.js') }}"></script>
</body>
</html>
