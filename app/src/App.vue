<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated class="glossy">
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
          icon="menu"
        />

        <q-toolbar-title>Adivise Health - ToDo</q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" bordered content-class="bg-grey-2">
    </q-drawer>

    <q-page-container>
      <q-page>
        <q-table
          title="TODO LIST"
          :data="todo"
          row-key="id"
          :columns="columns"
          :pagination="initialPagination"
        >
          <template v-slot:body-cell-id="props">
            <q-td :props="props">
              <q-btn
                :props="props"
                flat
                dense
                round
                icon="mdi-eye"
                color="primary"
                @click="infoTodo(props.row)"
              />
              <q-btn
                :props="props"
                flat
                dense
                round
                icon="mdi-pencil"
                color="primary"
                @click="editTodo(props.row)"
              />
              <q-btn
                :props="props"
                flat
                dense
                round
                icon="mdi-trash-can-outline"
                color="negative"
                @click="confirmDelete(props.row.id)"
              />
            </q-td>
          </template>
          <template v-slot:body-cell-completed="props">
            <q-td :props="props">
              <q-chip
                text-color="white"
                :icon="props.row.completed ? 'mdi-check' : 'mdi-close'"
                :color="props.row.completed ? 'positive' : 'negative'"
                :label="props.row.completed ? 'Completo' : 'Incompleto'"
              />
            </q-td>
          </template>
        </q-table>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import axios from "axios";
import moment from "moment";

export default {
  name: "LayoutDefault",

  components: {},

  data() {
    return {
      leftDrawerOpen: false,
      todo: [],
      initialPagination: {
        sortBy: "created_at",
        descending: true,
        page: 1,
        rowsPerPage: 20,
      },
      columns: [
        {
          name: "name",
          label: "Nome",
          field: "name",
          sortable: true,
          align: "left",
        },
        {
          name: "description",
          label: "Descrição",
          field: "description",
          sortable: true,
          align: "left",
        },
        {
          name: "completed",
          label: "Feito",
          field: "completed",
          sortable: true,
          align: "center",
        },
        {
          name: "tag",
          label: "TAG",
          field: "tag",
          sortable: true,
          align: "left",
        },
        {
          name: "created_at",
          label: "Criado em",
          field: "created_at",
          sortable: true,
          align: "left",
          format: (value) => moment(value).format("DD/MM/YYYY"),
        },
        {
          name: "updated_at",
          label: "Atualizado em",
          field: "updated_at",
          sortable: true,
          align: "left",
          format: (value) => moment(value).format("DD/MM/YYYY HH:mm"),
        },
        {
          name: "id",
          label: "Ação",
          field: "id",
          sortable: true,
          align: "right",
        },
      ],
    };
  },

  methods: {
    async todoList() {
      try {
        const { data, status } = await axios.get(
          "http://localhost:9000/api/todos"
        );
        if (status === 200) this.todo = data;
      } catch (error) {
        console.log(error);
      }
    },

    confirmDelete(id) {
      this.$q
        .dialog({
          title: "Confirmação",
          message: "Deseja realmente excluir este item?",
          cancel: "Não",
          ok: "Sim",
          color: "negative",
          icon: "mdi-alert-circle-outline",
        })
        .onOk(() => {
          this.todoDelete(id);
        });
    },

    async todoDelete(id) {
      try {
        const { status } = await axios.delete(
          "http://localhost:9000/api/todos/" + id
        );
        if (status === 204)
          this.todo = this.todo.filter((item) => item.id !== id);
      } catch (error) {
        console.log(error);
      }
    },

    async todoShow() {
      try {
        const { data, status } = await axios.get(
          "http://localhost:9000/api/todos" + id
        );
        if (status === 200) this.todo = data;
      } catch (error) {
        console.log(error);
      }
    },

    // async todoCreate() {
    //   try {
    //     const { data, status } = await axios.post(
    //       "http://localhost:9000/api/todos",
    //       data
    //     );
    //     if (status === 200) this.todo = data;
    //   } catch (error) {
    //     console.log(error);
    //   }
    // },

    // async todoEdit() {
    //   try {
    //     const { data, status } = await axios.put(
    //       "http://localhost:9000/api/todos",
    //       data
    //     );
    //     if (status === 200) this.todo = data;
    //   } catch (error) {
    //     console.log(error);
    //   }
    // },
  },

  created() {
    this.todoList();
  },
};
</script>

<style>
</style>
