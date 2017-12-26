<template>
    <div class="page-infos">
        <h2 class="title">
            <slot name="title"></slot>
        </h2>
        <ul>
            <li>
                <slot></slot>
            </li>
        </ul>
    </div>
</template>
<script>
    export default {
        props: {
        },
        methods: {
        }
    }
</script>
