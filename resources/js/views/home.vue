<template>
  <div>
    <v-row>
      <v-col cols="4">
        <EventForm @event-added="eventAdded" />
      </v-col>
      <v-col cols="8">
        <EventCalendar :events="events" />
      </v-col>
    </v-row>
  </div>
</template>

<script>
import EventForm from "../components/EventForm.vue";
import EventCalendar from "../components/EventCalendar.vue";

export default {
  data() {
    return {
      events: []
    };
  },
  name: "homepage",
  components: {
    EventForm,
    EventCalendar
  },
  async created() {
    await this.featchEvents();
  },
  methods: {
    featchEvents() {
      this.$api
        .get("/api/events/list")
        .then(res => (this.events = res.data.data));
    },
    async eventAdded() {
      await this.featchEvents();
    }
  }
};
</script>