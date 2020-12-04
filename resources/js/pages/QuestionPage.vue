<template>
    <div class="container">
        <question :question="question"></question>

        <answers :question="question"></answers>
    </div>
</template>

<script>
export default {
    props: ['question'],
}
</script>
