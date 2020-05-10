<template>
  <v-row class="fill-height">
    <v-col>
      <v-sheet height="64">
        <v-toolbar flat color="white">
          <v-btn text small @click="prev">
            <v-icon small>{{icons.left}}</v-icon>
          </v-btn>
          <v-toolbar-title class>{{ title }}</v-toolbar-title>
          <v-btn text small @click="next">
            <v-icon small>{{icons.right}}</v-icon>
          </v-btn>
        </v-toolbar>
      </v-sheet>
      <v-sheet height="600">
        <v-calendar
          :now="today"
          :event-margin-bottom="3"
          v-model="focus"
          @change="updateRange"
          ref="calendar"
          type="month"
          :events="calendarEvents"
        />
      </v-sheet>
    </v-col>
  </v-row>
</template>

<script>
import moment from "moment";
import { mdiChevronLeft, mdiChevronRight } from "@mdi/js";

export default {
  props: ["events"],
  data: () => ({
    test: [],
    start: null,
    end: null,
    today: moment().format("YYYY-MM-DD"),
    focus: moment().format("YYYY-MM-DD"),
    icons: {
      left: mdiChevronLeft,
      right: mdiChevronRight
    },
    calendarEvents: []
  }),
  methods: {
    prev() {
      this.$refs.calendar.prev();
    },
    next() {
      this.$refs.calendar.next();
    },
    updateRange({ start, end }) {
      this.start = start;
      this.end = end;
    }
  },
  mounted() {
    this.$refs.calendar.checkChange();
  },
  computed: {
    title() {
      const { start, end } = this;

      if (!start || !end) {
        return "";
      }

      const startMonth = this.monthFormatter(start);
      const startYear = start.year;
      return `${startMonth} ${startYear}`;
    },
    monthFormatter() {
      return this.$refs.calendar.getFormatter({
        timeZone: "UTC",
        month: "long"
      });
    }
  },
  watch: {
    events(val) {
      this.calendarEvents = val;
    }
  }
};
</script>
