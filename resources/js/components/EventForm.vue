<template>
  <v-row class="pa-3">
    <v-col cols="12">
      <v-text-field v-model="form.title" outlined flat placeholder="Enter description" />
    </v-col>
    <v-col>
      <v-menu
        ref="menu"
        v-model="menu"
        :close-on-content-click="false"
        :return-value.sync="date"
        transition="scale-transition"
        offset-y
        min-width="290px"
      >
        <template v-slot:activator="{ on }">
          <v-text-field
            outlined
            flat
            v-model="formatDateRange"
            label="Date range"
            :prepend-icon="icon"
            readonly
            v-on="on"
          ></v-text-field>
        </template>
        <v-date-picker range v-model="selectedDate" @input="setSelectedDate" no-title scrollable></v-date-picker>
      </v-menu>
    </v-col>
    <v-col cols="12">
      <div class="d-flex justify-space-between">
        <v-checkbox v-model="form.days" label="Mon" color="info" value="Mon" hide-details></v-checkbox>
        <v-checkbox v-model="form.days" label="Tue" color="info" value="Tue" hide-details></v-checkbox>
        <v-checkbox v-model="form.days" label="Wed" color="info" value="Wed" hide-details></v-checkbox>
        <v-checkbox v-model="form.days" label="Thu" color="info" value="Thu" hide-details></v-checkbox>
        <v-checkbox v-model="form.days" label="Fri" color="info" value="Fri" hide-details></v-checkbox>
        <v-checkbox v-model="form.days" label="Sat" color="info" value="Sat" hide-details></v-checkbox>
        <v-checkbox v-model="form.days" label="Sun" color="info" value="Sun" hide-details></v-checkbox>
      </div>
    </v-col>
    <v-col cols="12">
      <v-btn block color="primary" @click="create">SUMBIT</v-btn>
    </v-col>
  </v-row>
</template>

<script>
import { mdiCalendar } from "@mdi/js";

export default {
  name: "EventForm",
  data: () => ({
    form: {
      parent_id: "",
      title: "",
      color: "#00b4e0",
      days: []
    },
    date: [
      new Date().toISOString().substr(0, 10),
      new Date().toISOString().substr(0, 10)
    ],
    icon: mdiCalendar,
    menu: false,
    selectedDate: []
  }),
  created() {
    this.selectedDate = this.date;
  },
  methods: {
    setSelectedDate(date) {
      this.selectedDate = date.sort();
      this.selectedDate = this.selectedDate.sort();
    },
    create() {
      let data = {
        title: this.form.title,
        color: this.form.color,
        start_date: this.selectedDate[0],
        end_date: this.selectedDate[1],
        days: this.form.days,
        parent_id: this.form.parent_id
      };

      this.$api.post("/api/events/create", data).then(res => {
        this.$emit("event-added");
        this.form.parent_id = res.data.data[0].parent_id;
      });
    }
  },
  computed: {
    formatDateRange() {
      return this.selectedDate.join(" ~ ");
    }
  }
};
</script>
