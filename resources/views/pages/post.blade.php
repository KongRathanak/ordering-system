@extends('layouts.app')

@section('content')
    <section class="py-5">
        <div class="container">
            <div class="text-center lh-sm mb-5">
                <small class="text-muted text-uppercase">Category: <span class="text-muted">9 posts.</span></small>
                <h2 class="fs-1 fw-bolder m-0">
                    'Sport'
                </h2>
            </div>
            <div class="row gx-5">
                <div class="col-lg-8 mb-4">
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
                        class="mb-4"
                        :key="k"
                    >
                        <post-small-media
                            :category="category"
                            :date="date"
                            :title="title"
                            :content="content"
                            :user="user"
                            :img="img"
                            :category_link="category_link"
                            :link="link"
                            img_classes="img-post-media-lg"
                        />
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-5">
                        <h2 class="fs-3 fw-bolder pb-3 mb-4 border-bottom">
                            Popular posts
                        </h2>
                        <div class="row g-3">
                            <div
                                v-for="({
                                    category,
                                    date,
                                    title,
                                    user,
                                    img,
                                    category_link,
                                    link
                                }, k) in cards"
                                class="col-6 col-lg-12"
                                v-if="k < 4"
                                :key="k"
                            >
                                <post-card
                                    :category="category"
                                    heading_classes="text-truncate mb-2"
                                    img_classes="img-card-popular-post mb-1"
                                    meta_classes="mb-1"
                                    body_classes="py-2"
                                    :date="date"
                                    :title="title"
                                    :user="user"
                                    :img="img"
                                    :category_link="category_link"
                                    :link="link"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <h2 class="fs-3 fw-bolder pb-3 mb-4 border-bottom">
                            Categories
                        </h2>
                        <div
                            v-for="({
                                count,
                                title,
                                link
                            }, k) in categories"
                            class="mb-3"
                            :key="k"
                        >
                            <category-card
                                :count="count"
                                :title="title"
                                :link="link"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="py-5 bg-light bg-gradient">
        <div class="container">
            <h2 class="text-center fs-2 fw-bolder mb-5">
                Feature posts
            </h2>
            <div class="row gx-5">
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
                    :key="k"
                >
                    <post-card
                        v-if="k < 3"
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
    </section> --}}
@endsection

@push('after_scripts')
    <script src="{{ asset('js/home.js') . '?v=' . config('backpack.base.cachebusting_string') }}"></script>
@endpush
