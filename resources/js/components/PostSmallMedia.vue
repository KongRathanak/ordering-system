<template>
    <div class="d-flex">
        <div class="flex-shrink-0 me-3">
            <img
                :src="img"
                :alt="img"
                :class="`img-fluid rounded-3 post-media-sm-img-custom ${img_classes ? img_classes : 'img-post-media-sm'}`"
            >
        </div>
        <div class="flex-grow-1 align-self-center post-content">
            <div class="post-meta mb-1 text-muted">
                <a :href="category_link" class="category-sm fs-6 fw-bold text-decoration-none text-dark">
                    {{ category }}
                </a>
                —
                <span class="date-sm fs-6">
                    {{ date }}
                </span>
            </div>
            <h2
                class="heading-sm fs-5 fw-bold"
                data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                :title="title"
            >
                <a :href="link" class="text-decoration-none text-dark">
                    {{ title }}
                </a>
            </h2>
            <p v-if="content" class="text-muted content-sm">
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
        props: ['category', 'date', 'content', 'title', 'user', 'img', 'category_link', 'link', 'img_classes'],
    }
</script>
