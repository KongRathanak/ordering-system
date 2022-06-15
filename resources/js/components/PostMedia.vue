<template>
    <div class="d-block d-lg-flex align-items-center">
        <div class="flex-shrink-1 me-lg-5">
            <img
                :src="img"
                :alt="img"
                :class="`img-fluid rounded-3 mb-4 ${img_classes ? img_classes : 'post-media-img-custom'}`"
            >
        </div>
        <div class="w-100 post-content">
            <div class="post-meta mb-3 text-muted">
                <a :href="category_link" class="category fw-bold text-decoration-none text-dark">
                    {{ category }}
                </a>
                —
                <span class="date">
                    {{ date }}
                </span>
            </div>
            <h2
                class="heading-media fs-1 fw-bold"
                data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                :title="title"
            >
                <a :href="link" class="text-decoration-none text-dark">
                    {{ title }}
                </a>
            </h2>
            <p class="text-muted content-media">
                {{ content }}
            </p>
            <a href="#" class="post-author d-flex align-items-center text-decoration-none">
                <div
                    class="author-pic rounded-circle me-2"
                    :style="user.img ? `background-image: url(${user.img})` : 'background-color: rgba(0, 0, 0, 0.2)'"
                >
                    <div v-if="!user.img" class="d-flex justify-content-center">
                        <span class="text-white fs-5 fw-bold text-uppercase align-self-center p-1">
                            {{ user.name.slice(0, 1) }}
                        </span>
                    </div>
                </div>
                <div class="text-muted user-info-sm">
                    <strong
                        class="fw-bold text-dark d-block"
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom"
                        :title="user.name"
                    >
                        {{ user.name }}
                    </strong>
                    <span
                        data-bs-toggle="tooltip"
                        data-bs-placement="bottom"
                        :title="user.role"
                    >
                        {{ user.role }}
                    </span>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['category', 'date', 'title', 'content', 'user', 'img', 'category_link', 'link', 'img_classes'],
    }
</script>
