@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div :class="`container${slider_loaded ? '' : ' loading-skeleton'}`">
            <h2 class="text-center fs-2 fw-bolder mb-5">
                Feature
            </h2>
            <div id="feature-posts-slider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button
                        v-for="(v, k) in sliders.length"
                        type="button"
                        data-bs-target="#feature-posts-slider"
                        :data-bs-slide-to="k"
                        :class="k === 0 ? 'active' : ''"
                        aria-current="true"
                        :aria-label="`Slide ${k}`"
                        :key="k"
                    ></button>
                </div>
                <div class="carousel-inner">
                    <div
                        v-for="({
                            category,
                            date,
                            title,
                            content,
                            user,
                            img,
                            category_link,
                            link
                        }, k) in sliders"
                        :class="`carousel-item${k === 0 ? ' active' : ''}`"
                        data-bs-interval="5000"
                        :key="k"
                    >
                        <post-media
                            :category="category"
                            :date="date"
                            :title="title"
                            :content="content"
                            :user="user"
                            :img="img"
                            :category_link="category_link"
                            :link="link"
                        />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div :class="`container${card_loaded ? '' : ' loading-skeleton'}`">
            <div class="row g-5">
                <div
                    v-for="({
                        category,
                        date,
                        title,
                        content,
                        user,
                        img,
                        category_link,
                        link
                    }, k) in cards"
                    class="col-md-6 col-lg-4"
                    v-if="k < 9"
                    :key="k"
                >
                    <post-card
                        :category="category"
                        :date="date"
                        :title="title"
                        :content="content"
                        :user="user"
                        :img="img"
                        img_classes="img-card-post-lg"
                        :category_link="category_link"
                        :link="link"
                    />
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-light bg-gradient">
        <div :class="`container${category_loaded ? '' : ' loading-skeleton'}`">
            <div class="row g-5">
                <div
                    v-for="({
                        category,
                        articles,
                        link,
                    }, k) in categories"
                    :class="`col-lg-${categories.length > 1 ? '6' : '12'}`"
                    :key="k"
                >
                    <h2 class="fs-4 fw-bold mb-4">
                        <a :href="link" class="text-dark text-decoration-none">
                            @{{ category }}
                        </a>
                    </h2>
                    <div class="row g-4">
                        <div
                            v-for="({
                                category: cate_name,
                                date,
                                title,
                                user,
                                img,
                                category_link,
                                link: link_article
                            }, kk) in articles"
                            :class="`col-md-${categories.length > 1 ? '12' : '6'}`"
                            :key="kk"
                        >
                            <post-small-media
                                :category="cate_name"
                                :date="date"
                                :title="title"
                                :user="user"
                                :img="img"
                                :category_link="category_link"
                                :link="link_article"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('after_scripts')
    <script src="{{ asset('js/home.js') . '?v=' . config('backpack.base.cachebusting_string') }}"></script>
@endpush
