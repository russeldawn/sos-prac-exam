import axios from 'axios';

export default {
    getCustomers(param) {

        return axios({
            method: 'get',
            url: '/api/customers' + param.query,
        });
    },
	create(data) {
        return axios({
            method: 'post',
            url: '/api/customers',
            data: data
        });
    },
	read(id) {
        return axios({
            method: 'get',
            url: '/api/customers/' + id,
        });
    },
	update(id, data) {
        return axios({
            method: 'put',
            url: '/api/customers/' + id,
            data: data
        });
    },
	delete(id) {
        return axios({
            method: 'delete',
            url: '/api/customers/' + id,
        });
    },
    emailChecker(data) {
        return axios({
            method: 'post',
            url: '/api/customers/emailChecker',
            data: data
        });
    },
}
