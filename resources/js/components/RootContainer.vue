<template>
    <div>
        <Nav />

        <Modal
            v-show="showModal"
        />

        <router-view />
    </div>
</template>

<script>
import Nav from './Nav'
import Modal from './Modal'

export default {
    name: "RootContainer",
    props: [
        'idea',
    ],
    components: {
        Nav,
        Modal
    },
    async mounted () {
        /**
         * Check auth on the backend before doing anything else
         */
        await this.$store.dispatch('CHECK_AUTH');

        /**
         * Get request to get ideas by status id and count them
         */
        await this.$store.dispatch('COUNT_IDEAS_BY_STATUS')

        /**
         * Reset the state to not be saved in the localstorage
         * so the ERRORS won't persist when the page is refreshed
         */
        await this.$store.commit('resetState');

        /**
         * Receiving the SELECTED IDEA from the database
         */
        if (this.idea) // if this.idea exists add it to the payload
        {
           await this.$store.commit('setSelectedIdea', JSON.parse(this.idea)); // parses string to a javascript object
        }
    },
    computed: {
        /**
         * Return True to show the modal
         */
        showModal ()
        {
            return this.$store.state.modal.show;
        }
    }
}
</script>
