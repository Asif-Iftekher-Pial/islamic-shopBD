@if (get_setting('facebook_video_urls') != null)
<div id="fb-root"></div>
<script async defer src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.2"></script>
<div id="our_videos">
    <section class="mb-4">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 shadow-sm rounded">
                <div class="d-flex mb-3 align-items-baseline border-bottom">
                    <h3 class="h5 fw-700 mb-0">
                        <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Our Videos') }}</span>
                    </h3>
                </div>
                <div class="row gutters-10 row-cols-xxl-4 row-cols-xl-2 row-cols-lg-2 row-cols-md-2 row-cols-1">
                    @php $video_urls = json_decode(get_setting('facebook_video_urls')); @endphp
                    @foreach ($video_urls as $key => $value)
                    <div class="col text-center">
                        <div class="fb-video"
                            data-href="{{ $video_urls[$key] }}"
                            data-width="500"
                            data-allowfullscreen="true"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
@endif