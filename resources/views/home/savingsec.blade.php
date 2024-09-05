<!-- <section class="saving_section  mt-5 mb-5">
    <div class="box container">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="img-box">
              <img src="{{ asset('assets/images/saving-img.png') }}" alt="">
            </div>
          </div>
          <div class="col-lg-6">
            <div class="detail-box">
              <div class="heading_container">
                <h1 style="margin-bottom: 0;">
                 Check Out<br>
                  <h2 style="margin-bottom: 0;">Promotions  Collection</h2>
                  
                  

                  
                </h1>
              </div>
              <p>
                Qui ex dolore at repellat, quia neque doloribus omnis adipisci, ipsum eos odio fugit ut eveniet blanditiis praesentium totam non nostrum dignissimos nihil eius facere et eaque. Qui, animi obcaecati.
              </p>
              <div class="btn-box">
                <a href="" class="btn1">
                  Explore more <i class="fas fa-arrow-right"></i>
                </a>
               
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
-->

<div class="promotions">
    <div class="container">
        <div class="card-slider">

            @foreach ($packs as $pack)
                <div class="card-slide">
                    <div class="card centered-card">
                        <div class="card-body">
                            <img src="{{ asset('images/packs/' . ($pack->image ?? 'default.jpg')) }}"
                                class="top-svg mb-2" alt="Top SVG">
                            <h2 class="fw-bold fs-4">{{ $pack->name }}</h2>

                            <address>
                                <!-- Show up to 3 product names with "..." if more -->
                                {{ $pack->description }}
                            </address>
                            <strong>
                                <p style="font-size:17px;color: green ;s" > {{ $pack->price }} DH</p>
                            </strong>
                            <div class="d-flex justify-content-center mt-3">
                                <a href="{{ route('showpack', ['id' => $pack->id]) }}"
                                    class="btn custom-btn search-button">Show More Information</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach








        </div>
        <div class="btn-box">
            <a href="{{ Route('lespacks') }}">
                View All Products <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
