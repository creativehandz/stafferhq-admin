<template>
    <nav class="chats-navbar">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Chats</a></li>
            <li><a href="#">Contacts</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: 'ChatsNavbar'
}
</script>

<style scoped>
.chats-navbar {
    background-color: #333;
    padding: 1rem;
}

.chats-navbar ul {
    list-style: none;
    display: flex;
    gap: 1rem;
}

.chats-navbar a {
    color: white;
    text-decoration: none;
}
</style>
