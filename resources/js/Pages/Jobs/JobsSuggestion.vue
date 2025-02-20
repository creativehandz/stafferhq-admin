<script>
export default {
    data() {
        return {
            jobs: [
                { id: 1, title: 'Software Engineer' },
                { id: 2, title: 'Data Scientist' },
                { id: 3, title: 'Product Manager' }
            ]
        };
    }
};
</script>

<style scoped>
.jobs-suggestion {
    padding: 20px;
}

.jobs-suggestion h1 {
    font-size: 24px;
    margin-bottom: 10px;
}

.jobs-suggestion ul {
    list-style-type: none;
    padding: 0;
}

.jobs-suggestion li {
    margin: 5px 0;
}
</style>

<template>
    <div class="jobs-suggestion">
        <h1>Job Suggestions</h1>
        <ul>
            <li v-for="job in jobs" :key="job.id">{{ job.title }}</li>
        </ul>
    </div>
</template>