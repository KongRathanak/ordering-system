<template>
    <a :href="link" class="card bg-dark border-0 rounded-3 text-decoration-none">
        <div :class="`card-body d-flex justify-content-between post-content ${body_classes ? body_classes : 'py-3'}`">
            <h2
                :class="`heading fs-5 m-0 me-4 text-truncate text-white text-decoration-none ${heading_classes}`"
                data-bs-toggle="tooltip"
                data-bs-placement="bottom"
                :title="title"
            >
                {{ title }}
            </h2>
            <span class="text-white fw-bold align-self-end text-decoration-none">
                {{ count }}
            </span>
        </div>
    </a>
</template>

<script>
    export default {
        props: ['body_classes', 'title', 'link', 'heading_classes', 'count'],
    }
</script>
