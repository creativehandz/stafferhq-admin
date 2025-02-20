<template>
    <div class="chat-empty">
        <p>No chats available. Start a new conversation!</p>
    </div>
</template>

<script>
export default {
    name: 'ChatEmpty'
}
</script>

<style scoped>
.chat-empty {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    font-size: 1.2em;
    color: #888;
}
</style>