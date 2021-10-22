<template>
    <div class="w-100 card px-4 ">
        <div class="card-header bg-success text-white">
            VUE REAL TIME CHAT APPLICATION {{ totalchatusers }} in the room
        </div>
        <div class="card-body">
            <ul
                v-chat-scroll="{
                    always: false,
                    smooth: true,
                    scrollonremoved: true
                }"
                style="height:300px;overflow:auto"
            >
                <div
                    :class="classPosition(msg)"
                    v-for="msg in messages"
                    v-bind:key="msg.message"
                >
                    <div>
                        <div class="alert alert-primary" role="alert">
                            {{ msg.message }}
                        </div>
                        <span class="mr-auto">
                            {{ msg.user.name }}
                            <!-- arkar -->
                        </span>
                    </div>
                </div>
            </ul>
        </div>
        <span class="alert alert-warning mb-0 text-sm p-1" v-if="typing">{{
            typing
        }}</span>
        <!-- <span >Something</span> -->
        <input
            type="text"
            class="form-control"
            placeholder="Send Message"
            v-model="message"
            @focus="setTypingStatus"
            @blur="setTypingStatusNull"
        />
        <button @click="addNewMsg" class="btn btn-success">Add</button>
    </div>
</template>

<script>
import Vue from "vue";

import Toaster from "v-toaster";
import "v-toaster/dist/v-toaster.css";
Vue.use(Toaster, { timeout: 5000 });

export default {
    props: { user: Object },
    data() {
        return {
            sender: Object,
            messages: [
                {
                    user: 1,
                    message: "hello"
                }
            ],
            message: "",
            typing: "",
            totalchatusers: ""
        };
    },
    // watch: {
    //     message() {
    //         // console.log("User is Typing");
    //         if (!this.message)
    //             Echo.private("chat").whisper("typing", {
    //                 typing: ""
    //             });

    //         Echo.private("chat").whisper("typing", {
    //             typing: `${this.sender?.name} is typing`
    //         });
    //     }
    // },
    methods: {
        setTypingStatus() {
            Echo.private("chat").whisper("typing", {
                typing: `${this.sender?.name} is typing`
            });
        },
        setTypingStatusNull() {
            Echo.private("chat").whisper("typing", {
                typing: ""
            });
        },
        classPosition(msg) {
            return msg.user.id === this.sender.id
                ? "d-flex  justify-content-end"
                : "d-flex  justify-content-start";
        },
        addNewMsg() {
            axios
                .post("/chat", { message: this.message, user: this.sender })
                .then(() => {
                    console.log("success");
                });
            this.message = "";
        }
    },
    mounted() {
        this.sender = this.user;

        Echo.private("chat")
            .listen(".chat-event", e => {
                this.messages.push(e);

                console.log(e);
            })
            .listenForWhisper("typing", e => {
                if (e) {
                    console.log(e);
                    this.typing = e.typing;
                } else {
                    this.typing = "";
                }
            });

        Echo.join("chat")
            .here(users => {
                this.totalchatusers = users.length;
            })
            .joining(user => {
                this.totalchatusers += 1;
                this.$toaster.success(`${user.name} Joined the Chat!`);
            })
            .leaving(user => {
                this.totalchatusers -= 1;
                this.$toaster.error(`${user.name} Left the Chat!`);
            });
    }
};
</script>

<style lang="scss" scoped></style>
