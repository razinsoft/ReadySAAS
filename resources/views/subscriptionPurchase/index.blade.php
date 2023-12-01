@extends('layout.app')
@section('title', __('subscription_purchase'))
@section('content')
    <section>
        <div class="subscription-container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <span class="list-title">{{ __('subscription_purchase') }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($subscriptions as $subscription)
                            <div class="col-md-4">

                                <div class="subscription-container">
                                    <h2 class="title">{{ $subscription->title }}</h2>
                                    <h3 class="price">
                                        {{ numberFormat($subscription->price) }}<span>/{{ $subscription->recurring_type }}</span>
                                    </h3>
                                    <b class="offer">You can create {{ $subscription->shop_limit }} branche and also create
                                        {{ $subscription->product_limit }} products for a branch.</b>
                                    <p class="description description-content">{{ $subscription->description }}.</p>
                                    <button id="see-more">See More</button>
                                    <button type="button" data-action="{{ route('subscription-purchase.update', $subscription->id) }}"
                                        class="subscribe-button">Subscribe Now</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const content = document.querySelector('.description-content');
            const seeMoreBtn = document.getElementById('see-more');

            seeMoreBtn.addEventListener('click', function() {
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                    seeMoreBtn.textContent = 'See Less';
                } else {
                    content.style.maxHeight = content.scrollHeight + 'px';
                    seeMoreBtn.textContent = 'See More';
                }
            });
        });

        $('.subscribe-button').on("click", function() {
            const action = $(this).attr('data-action');
            new swal({
                title: "Are you sure?",
                text: "To purchase this subscription",
                type: "warning",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#29aae1",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.value) {
                    window.location.href = action;
                }
            });
        });
    </script>
@endpush
