<template>
    <div class="chat">
        <!-- Display chat messages -->
        <div v-for="chat in chats" :key="chat.chat_id" class="chat-card">
            <img :src="chat.user.image" alt="User Image" class="user-image">
            <div class="chat-content">
                <h5 class="chat-username">{{ chat.user.name }}</h5>
                <img v-if="chat.message_type == 'image'" class="chat-message message-image" :src="chat.message">
                <audio v-else-if="chat.message_type == 'audio'" controls>
                    <source :src="chat.message">
                    Your browser does not support the audio element.
                </audio>
                <p v-else class="chat-message">{{ chat.message }}</p>
                <small class="chat-time">{{ chat.sent_at }}</small>
            </div>
        </div>
    </div>
</template>

<script>
import io from 'socket.io-client';

export default {
    props: ["resourceName", "resourceId", "panel"],
    data() {
        return {
            chats: this.panel.fields[0]["messages"]
        }
    },
    mounted() {
        const socket = io('http://127.0.0.1:3000'); // Replace with your Socket.IO server URL

        socket.on('connect', () => {
            console.log(this.resourceId);
            console.log('Connected to Socket.IO server');
        });

        socket.on('disconnect', () => {
            console.log('Disconnected from Socket.IO server');
        });

        // Handle incoming chat messages
        socket.on('chat_' + this.resourceId, (message) => {
            this.handleIncomingMessage(message);
        });
    },
    methods: {
        handleIncomingMessage(message) {
            // Push the incoming message to the chats array
            this.chats.push(message);
        }
    }
};
</script>

<style scoped>
.chat-card {
    display: flex;
    align-items: center;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    background-color: #f7f7f7;
}

.user-image {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.message-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin: 0px 10px;
}

.chat-content {
    flex: 1;
}

.chat-username {
    margin: 0;
    color: #333;
}

.chat-message {
    margin: 5px 0;
    color: #666;
}

.chat-time {
    color: #999;
    font-size: 0.8em;
}
.chat {
    overflow-y: scroll;
    height: 300px;
}
.chat::-webkit-scrollbar {
  width: 1em;
}

.chat::-webkit-scrollbar-track {
  box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
}

.chat::-webkit-scrollbar-thumb {
  background-color: darkgrey;
  outline: 1px solid slategrey;
}
</style>
