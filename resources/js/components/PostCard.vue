<template>
    <div class="card bg-transparent border-0">
        <img
            :src="img"
            :alt="img"
            :class="`rounded-3 post-card-img-custom ${img_classes ? img_classes : ''}`"
        >
        <div :class="`card-body px-0 post-content ${body_classes ? body_classes : 'py-3'}`">
            <div :class="`post-meta text-muted ${meta_classes ? meta_classes : 'mb-2'}`">
                <a :href="category" class="category fw-bold text-decoration-none text-dark">
                    {{ category }}
                </a>
                —
                <span class="date">
                    {{ date }}
                </span>
            </div>
            <h2
                :class="`heading fs-4 fw-bold ${heading_classes ? heading_classes : 'mb-3'}`"
                data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                :title="title"
            >
                <a :href="link" class="text-decoration-none text-dark w-100">
                    {{ title }}
                </a>
            </h2>
            <p v-if="content" class="text-muted content">
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
                <div
                    class="text-muted user-info-sm"
                >
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
        props: ['category', 'meta_classes', 'date', 'title', 'content', 'body_classes', 'user', 'img', 'category_link', 'link', 'heading_classes', 'img_classes'],
    }
</script>
