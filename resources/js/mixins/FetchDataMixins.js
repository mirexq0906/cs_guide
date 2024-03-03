import axios from "axios";

export default {
    data() {
        return {
            loader: false,
            isError: false,
            errorMessage: '',
        }
    },
    methods: {
        async fetchGetData(url, params = {}) {
            try {
                this.loader = true
                const response = await axios.get('http://127.0.0.1:8000/api' + url, { params })
                if (response.data?.data?.success) {
                    return response.data?.data
                } else {
                    this.isError = true
                    this.errorMessage = response.data?.data?.message
                }
            } catch (e) {
                console.log(e)
            } finally {
                this.loader = false
            }
        },
        async fetchPostCreateData(url, data) {
            try {
                this.loader = true
                const response = await axios.post('http://127.0.0.1:8000/api' + url, data)
                if (response.data?.data?.success) {
                    this.$toast.add({
                        severity: 'success',
                        summary: 'Подтверждение',
                        detail: 'Запись создана',
                        life: 3000
                    });
                    return response.data?.data
                } else {
                    this.isError = true
                    this.errorMessage = response.data?.data?.message
                }
            } catch (e) {
                console.log(e)
            } finally {
                this.loader = false
            }
        },
        async fetchPostUpdateData(url, data) {
            try {
                this.loader = true
                const response = await axios.post('http://127.0.0.1:8000/api' + url, data)
                if (response.data?.data?.success) {
                    this.$toast.add({
                        severity: 'success',
                        summary: 'Подтверждение',
                        detail: 'Запись изменена',
                        life: 3000
                    });
                    return response.data?.data
                } else {
                    this.isError = true
                    this.errorMessage = response.data?.data?.message
                }
            } catch (e) {
                console.log(e)
            } finally {
                this.loader = false
            }
        },
        async fetchDeleteData(url) {
            try {
                this.loader = true
                const response = await axios.delete('http://127.0.0.1:8000/api' + url)
                if (response.data?.data?.success) {
                    this.$toast.add({
                        severity: 'success',
                        summary: 'Подтверждение',
                        detail: 'Запись удалена',
                        life: 3000
                    });
                    return response.data?.data
                } else {
                    this.isError = true
                    this.errorMessage = response.data?.data?.message
                }
            } catch (e) {
                console.log(e)
            } finally {
                this.loader = false
            }
        },

        async fetchGetTableData(url, data) {
            try {
                this.loader = true
                let params = {}
                if (data) {
                    params = this.queryParamsData = this.convert(data)
                }
                const response = await axios.get('http://127.0.0.1:8000/api' + url, {params})
                if (response.data?.data?.success) {
                    this.dataTable = response?.data?.data?.payload ?? [];
                    this.dataTotalRecords = response?.data?.data?.total ?? 0;
                } else {
                    this.isError = true
                    this.errorMessage = response.data?.data?.message
                }
            } catch (e) {
                console.log(e)
            } finally {
                this.loader = false
            }
        },
        convert(data) {
            const params = {}
            const filters = []
            params.page = data.first / data.rows + 1
            params.limit = data.rows
            if (data?.sortField != null) {
                params.sort = {
                    field: data.sortField,
                    order: data.sortOrder === 1 ? "ASC" : "DESC"
                }
                for (let i = 0; i < data.multiSortMeta.length; i++) {
                    params.orders.push({
                        fieldname: data.multiSortMeta[i].field,
                        direction: data.multiSortMeta[i].order === 1 ? "ASC" : "DESC"
                    })
                }
            }
            for (let key in data.filters) {
                if (data.filters[key].value === false || data.filters[key].value) {
                    let operator = null;
                    switch (data.filters[key].matchMode) {
                        case 'equals':
                            operator = 'equal'
                            break;
                        case 'contains':
                            operator = 'like'
                            break;
                    }
                    filters.push(
                        {
                            field: key,
                            operator: operator,
                            value: data.filters[key].value
                        }
                    )
                }
            }
            if (filters.length) {
                params.filters = filters
            }
            return params
        },
        clearError() {
            this.isError = false
            this.errorMessage = ''
        }
    }
}
