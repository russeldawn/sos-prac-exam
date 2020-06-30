<template>
    <div>
        <div>
            <a-table :columns="columns" :data-source="data" :pagination="false">
                <a slot="name" slot-scope="text">{{ text }}</a>

                <span slot="action" slot-scope="record, index">
					<a-dropdown>
						<a class="ant-dropdown-link">
							<a-icon type="ellipsis" />
							<a-icon type="down" />
						</a>

						<a-menu slot="overlay">
							<a-menu-item key="1" @click="editRow(record)">
								Edit
							</a-menu-item>

							<a-menu-item key="2" @click="viewRow(record)">
								View
							</a-menu-item>

							<a-menu-item key="3" @click="deleteRow(record)">
								Delete
							</a-menu-item>
						</a-menu>

					</a-dropdown>
				</span>

            </a-table>
        </div>

        <div>
            <a-pagination
                v-model="currentPage"
                show-size-changer
                :show-total="showTotal"
                :default-current="1"
                :total="userTotal"
                @showSizeChange="onShowSizeChange"
                @change="changePagination"
                :pageSizeOptions="pageSizeOptions"
                :pageSize="pageSize"
            />
        </div>
    </div>

</template>

<script>
import Customer from "../../js/services/customer";
import _ from 'lodash';

const columns = [
	{
		title: "Name",
		dataIndex: "name",
		key: "name",
        scopedSlots: { customRender: "name" },
        width: 200
	},
	{
		title: "Email",
		dataIndex: "email",
		key: "email",
		width: 230
	},
	{
		title: "Address",
		dataIndex: "address",
		key: "address",
        ellipsis: true,
        width: 280
	},
	{
		title: "Gender",
		dataIndex: "gender",
        key: "gender",
        width: 150
    },
    {
		title: "Action",
		key: "action",
		scopedSlots: {
			customRender: "action"
        },
        width: 80
	}
];

const data = [
	{
		key: "1",
		name: "John Brown",
		age: 32,
		address: "New York No. 1 Lake Park, New York No. 1 Lake Park",
		tags: ["nice", "developer"]
	},
	{
		key: "2",
		name: "Jim Green",
		age: 42,
		address: "London No. 2 Lake Park, London No. 2 Lake Park",
		tags: ["loser"]
	},
	{
		key: "3",
		name: "Joe Black",
		age: 32,
		address: "Sidney No. 1 Lake Park, Sidney No. 1 Lake Park",
		tags: ["cool", "teacher"]
	}
];

export default {
    beforeMount() {
        this.customers(this.currentPage, this.pageSize)
    },
	data() {
		return {
			data,
            columns,
            userTotal: 0,
			pageSize: 10,
			currentPage: 1,
			pageSizeOptions: ['5','10','15', '20'],
		};
    },
    methods: {
        editRow(customer){
            this.$router.push({ name: 'update' , params: { id: customer.key}});
        },
        viewRow(customer){
            this.$router.push({ name: 'read' , params: { id: customer.key}});

        },
        deleteRow(customer){
            console.log('customer: ', customer);

            this.deleteCustomer(customer)

        },
        customers(currentPage = null, page_size = null) {

            let notify = {
                type: '',
                message: '',
                description: '',
            }

            let query = '?page=' + this.currentPage;
			let payload = {};

			if (currentPage != null) {
				query = '?page=' + currentPage;
				payload.query = query;
			}

			if (page_size != null) {
				payload.query += '&page_size=' + page_size;
            }

            Customer.getCustomers(payload)
                .then(response => {
                    let self = this;

                    self.data = [];

                    if (response.status == 200 && response.data.data) {

                        let cloneData = response.data.data;

                        this.currentPage = response.data.current_page;

                        cloneData.map(customer => {
                            let new_data = {
                                'key': customer.id,
                                'name': customer.first_name + ' ' + customer.last_name,
                                'email': customer.email,
                                'gender': customer.gender == 1 ? 'male' : 'female',
                                'address': customer.address
                            }

                            self.data.push(new_data);

                        });

                    }

                })
                .catch(error => {
                    console.log('error: ', error);

                    notify.type = 'error',
                    notify.message = 'Error',
                    notify.description = 'There was an error retrieving data from the server.',

                    this.openNotificationWithIcon(notify)

                })
        },
        onShowSizeChange(currentPage, pageSize) {

            if (currentPage != 0) {
                this.currentPage = currentPage;
            }

			this.pageSize = pageSize;

			this.customers(this.currentPage, this.pageSize);
		},
		changePagination(currentPage, pageSize) {

            if (currentPage != 0) {
                this.currentPage = currentPage;
            }
			this.pageSize = pageSize;

			this.customers(this.currentPage, this.pageSize);
        },
        resetForm() {
			this.$refs.ruleForm.resetFields();
        },
        openNotificationWithIcon(meta) {
            this.$notification[meta.type]({
                message: meta.message,
                description: meta.description,
            });
        },
        deleteCustomer(customer) {
            let self = this;
            let dataIndex =  _.findIndex(this.data, customer);

            Customer.delete(customer.key)
                    .then(response => {

                        let notify = {
                                type: '',
                                message: '',
                                description: '',
                        }

                        if (response.data.status === 200) {

                            self.data.splice(dataIndex, 1);

                            notify.type = 'success',
                            notify.message = 'Success',
                            notify.description = 'Successfully deleted customer ' + customer.name + '.',

                            self.openNotificationWithIcon(notify);



                        } else if (response.data.status === 400) {

                            notify.type = 'error',
                            notify.message = 'Error',
                            notify.description = response.data.errors[0],

                            self.openNotificationWithIcon(notify)

                        }
                    })
                    .catch(error => {
                        console.log('error: ', error);

                    })
		},
    }
};
</script>
