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
      <q-dialog v-model="dialogMode" persistent>
        <q-card>
          <q-card-section class="row items-center">
            <span class="q-ml-sm" v-if="mode == 'view'"> </span>
            <span class="q-ml-sm" v-if="mode == 'edit'">
              <q-card class="my-card">
                <q-toolbar class="bg-purple text-white">
                  <q-btn flat round dense icon="assignment_ind" />
                  <q-toolbar-title> Editar </q-toolbar-title>
                  <q-btn flat round dense icon="mdi-close" @click="onClose" />
                </q-toolbar>
                <q-form class="q-gutter-md">
                  <q-card-section class="row q-col-gutter-md">
                    <div class="col-12">
                      <q-input
                        v-model="todoSelect.name"
                        :label="'Name'"
                        outlined
                      />
                    </div>
                    <div class="col-12">
                      <q-input
                        v-model="todoSelect.description"
                        :label="'Description'"
                        outlined
                      />
                    </div>
                    <div class="col-12">
                      <q-input
                        v-model="todoSelect.tag"
                        :label="'Tag'"
                        outlined
                      />
                    </div>
                    <div class="col-12">
                      <q-select
                        v-model="todoSelect.completed"
                        :label="'Completed'"
                        outlined
                        :options="[
                          { label: 'Completo', value: 1 },
                          { label: 'Incompleto', value: 0 },
                        ]"
                        option-label="label"
                        option-value="value"
                      />
                    </div>
                  </q-card-section>
                  <div>
                    <q-btn label="Submit" type="submit" color="primary" />
                    <q-btn
                      label="Reset"
                      type="reset"
                      color="primary"
                      flat
                      class="q-ml-sm"
                    />
                  </div>
                </q-form>
              </q-card>
            </span>
          </q-card-section>
          <q-card-actions align="right">
            <q-btn flat label="Cancel" color="primary" v-close-popup />
            <q-btn flat label="Turn on Wifi" color="primary" v-close-popup />
          </q-card-actions>
        </q-card>
      </q-dialog>
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
                @click="openDialog(props.row, 'view')"
              />
              <q-btn
                :props="props"
                flat
                dense
                round
                icon="mdi-pencil"
                color="primary"
                @click="openDialog(props.row, 'edit')"
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
        // {
        //   name: "description",
        //   label: "Descrição",
        //   field: "description",
        //   sortable: true,
        //   align: "left",
        // },
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
      mode: null,
      todoSelect: null,
    };
  },

  computed: {
    dialogMode() {
      return this.mode ? true : false;
    },
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

    openDialog(infoItem, mode) {
      this.mode = mode;
      this.todoSelect = infoItem;
    },

    async todoShow() {
      try {
        const { data, status } = await axios.get(
          "http://localhost:9000/api/todos"
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
