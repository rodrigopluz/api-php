Vue.use(VueMask.VueMaskPlugin);

var app = new Vue({
    el: "#root",
    data: {
		clicked: {},
        citizens: [],
        dataTable: null,
		errorMessage : "",
        showingModal:false,
		successMessage : "",
		showingeditModal: false,
        showingdeleteModal: false,
        newapi: { name: "", surname: "", cpf: "", email: "", phone: "", cellphone: "", zipcode: "", logradouro: "", neighborhood: "", city: "", state: "" },
    },
    mounted: function () {
        this.getAll2SOW();
        this.dataTable = $('#listDataTable').DataTable({
            searching: false,
            paging: false,
            info: false
        });
    },
    methods: {
        // read - lista todos os registros
        getAll2SOW: function () {
            axios.get("http://localhost/api-2sow/api.php?action=read")
                .then(function (res) {
                    if (res.data.error) {
                        app.errorMessage = res.data.message;
                    } else {
                        app.citizens = res.data.citizens;
                    }
                });
        },
        // cread - cria um novo registro
        save: function () {
            var formData = app.toFormData(app.newapi);
            axios.post("http://localhost/api-2sow/api.php?action=create", formData)
                .then(function (res) {
                    app.newapi = { name: "", surname: "", cpf: "" };

                    if (res.data.error) {
                        app.errorMessage = res.data.message;
                    } else {
                        app.successMessage = res.data.message;
						app.getAll2SOW();
                    }
                });
        },
        // update - atualiza um registro selecionado
        update: function () {
            var formData = app.toFormData(app.clicked);
            axios.post("http://localhost/api-2sow/api.php?action=update", formData)
				.then(function (res) {
					app.clicked = {};

                    if (res.data.error) {
						app.errorMessage = res.data.message;
					} else {
						app.successMessage = res.data.message;
						app.getAll2SOW();
					}
				});
        },
        // delete - deleta um registro selecionado
        delete2SOW: function () {
            var formData = app.toFormData(app.clicked);

			axios.post("http://localhost/api-2sow/api.php?action=delete", formData)
				.then(function (res) {
					app.clicked = {};

                    if (res.data.error) {
						app.errorMessage = res.data.message;
					} else {
						app.successMessage = res.data.message;
						app.getAll2SOW();
					}
				});
        },
        // select - faz a verificação se o usuario clicou no edit ou no delete
        select(req) {
            app.clicked = req;
        },
        // toFormData - função que verifica os parametros passados.
        toFormData: function (obj) {
            var form_data = new FormData();
            for (var key in obj) {
                form_data.append(key, obj[key]);
            }

            return form_data;
        },
        // clearMessage - mostra as mensagem de erro ou de sucesso
        clearMessage: function () {
            app.errorMessage = "";
            app.successMessage = "";
        },
        // searchCEP - consulta na api do via-cep
        searchCEP: function () {
            // method modal add
            if (app.newapi.zipcode.length >= 8) {
                axios.get('https://viacep.com.br/ws/' + app.newapi.zipcode + '/json')
                    .then(function (res) {
                        app.newapi.state        = res.data.uf;
                        app.newapi.neighborhood = res.data.bairro;
                        app.newapi.logradouro   = res.data.logradouro;
                        app.newapi.city         = res.data.localidade;
                    });
            }

            // method modal edit
            if (app.clicked.zipcode.length >= 8) {
                axios.get('https://viacep.com.br/ws/' + app.clicked.zipcode + '/json')
                    .then(function (res) {
                        app.clicked.state        = res.data.uf;
                        app.clicked.neighborhood = res.data.bairro;
                        app.clicked.logradouro   = res.data.logradouro;
                        app.clicked.city         = res.data.localidade;
                    });
            }
        }
    }
});