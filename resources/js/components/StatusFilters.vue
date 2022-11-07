<template>
    <div>
        <nav class="hidden md:flex items-center justify-between text-xs"> <!-- SCROLL-RIGHT MENU HIDDEN MOBILE -->
            <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
                <li>
                    <a
                        @click.stop="setStatusFilter(0)"
                        :class="statusId === 0 ? this.activeClass : this.inactiveClass"
                    >
                        All ideas ({{ this.counts.all }})
                    </a>
                </li>
                <li>
                    <a
                        @click.stop="setStatusFilter(2)"
                        :class="statusId === 2 ? this.activeClass : this.inactiveClass"
                    >
                        Considering ({{ this.counts.considering }})
                    </a>
                </li>
                <li>
                    <a
                        @click.stop="setStatusFilter(3)"
                        :class="statusId === 3 ? this.activeClass : this.inactiveClass"
                    >
                        In Progress ({{ this.counts.inProgress }})
                    </a>
                </li>
            </ul>

            <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
                <li>
                    <a
                        @click.stop="setStatusFilter(4)"
                        :class="statusId === 4 ? this.activeClass : this.inactiveClass"
                    >
                        Implemented ({{ this.counts.implemented }})
                    </a>
                </li>
                <li>
                    <a
                        @click.stop="setStatusFilter(5)"
                        :class="statusId === 5 ? this.activeClass : this.inactiveClass"
                    >
                        Closed ({{ this.counts.closed }})
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    name: "StatusFilters",
    data () {
        return {
            statusId: 0,
            activeClass: 'border-b-4 pb-3 border-blue',
            inactiveClass: 'text-gray-400 transition duration-150 ease-in border-b-4 pb-3 hover:border-blue'
        };
    },
    computed: {
        /**
         * Count ideas by status
         */
        counts ()
        {
            return this.$store.state.ideas.counts;
        }
    },
    methods: {
        /**
         * this.statusId will become the statusId I'm passing in
         */
        async setStatusFilter (statusId)
        {
            this.statusId = statusId;

            const action = (this.statusId === 0) ? 'GET_PAGINATED_IDEAS' : 'GET_PAGINATED_IDEAS_BY_STATUS_ID'

            await this.$store.dispatch(action, statusId);
        }
    }
}
</script>

<style scoped>

</style>
