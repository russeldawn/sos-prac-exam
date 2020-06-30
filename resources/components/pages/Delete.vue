<template>
	<a-form-model
		:model="form"
		:label-col="labelCol"
		:wrapper-col="wrapperCol"
	>
		<a-form-model-item ref="first_name" label="First Name" prop="first_name">
			<a-input
				v-model="form.first_name"
			/>
		</a-form-model-item>

		<a-form-model-item ref="last_name" label="Last Name" prop="last_name">
			<a-input
				v-model="form.last_name"
			/>
		</a-form-model-item>

		<a-form-model-item ref="email" label="Email" prop="email">
			<a-input
				v-model="form.email"
			/>
		</a-form-model-item>

		<a-form-model-item ref="address" label="Address" prop="address">
			<a-input
				v-model="form.address"
			/>
		</a-form-model-item>

		<a-form-model-item label="Gender" prop="gender">
            <a-input
				v-model="form.gender"
			/>
		</a-form-model-item>

	</a-form-model>
</template>


<script>
import Customer from "../../js/services/customer";

export default {
    beforeMount() {

        let customer_id = null;
        let notify = {
            type: '',
            message: '',
            description: '',
        }

        if (this.$route.params.id) {
            let customer_id = this.$route.params.id;

            Customer.read(customer_id)
                    .then(response => {

                        let customer = response.data.data;

                        switch (response.data.data.gender) {
                            case 0:
                                customer.gender = 'female';
                                break;
                            case 1:
                                customer.gender = 'male';
                                break;
                        }

                        if (response.data.status === 200) {
                            this.form = customer;
                        }

                    })
                    .catch(error => {
                        console.log('error: ', error);

                        notify.type = 'error',
                        notify.message = 'Error',
                        notify.description = 'Customer does not exists in our records.',

                        this.openNotificationWithIcon(notify)

                    })

        }

        this.deleteCustomer(this.$route.params.id)

    },
	data() {

        let validateEmail = (rule, value, callback) => {

            const pattern = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
            let isValid = pattern.test(value);

            if (isValid == false) {
                callback(new Error('Please input a valid email.'));
            } else {
                callback();
            }

        };


		return {
			labelCol: { span: 4 },
			wrapperCol: { span: 14 },
			other: '',
			form: {
				first_name: '',
                last_name: '',
                email: '',
                address: '',
                gender: '',
			},
			rules: {
				first_name: [
					{ required: true, message: 'Please input first name', trigger: 'blur' },
					{ min: 3, max: 100, message: 'Length should be 3 to 100', trigger: 'blur' },
				],
				last_name: [
					{ required: true, message: 'Please input last name', trigger: 'blur' },
					{ min: 3, max: 100, message: 'Length should be 3 to 100', trigger: 'blur' },
				],
				email: [
					{ required: true, message: 'Please input email', trigger: 'blur' },
					{ min: 3, max: 100, message: 'Length should be 3 to 100', trigger: 'blur' },
					{ validator: validateEmail, trigger: 'change' },
				],
				address: [
					{ required: true, message: 'Please input address', trigger: 'blur' },
					{ min: 3, max: 255, message: 'Length should be 3 to 255', trigger: 'blur' },
				],
				gender: [{ required: true, message: 'Please select gender', trigger: 'change' }],
			},
		};
	},
	methods: {
		deleteCustomer(customer_id) {

            Customer.delete(customer_id)
                    .then(response => {

                        let notify = {
                                type: '',
                                message: '',
                                description: '',
                        }

                        if (response.data.status === 200) {

                            notify.type = 'success',
                            notify.message = 'Success',
                            notify.description = 'Successfully created new Customer.',

                            this.openNotificationWithIcon(notify);

                            this.resetForm();

                            setTimeout(() => {
                                this.$router.push({ name: 'list' });
                            }, 3000)

                        } else if (response.data.status === 400) {

                            notify.type = 'error',
                            notify.message = 'Error',
                            notify.description = response.data.errors[0],

                            this.openNotificationWithIcon(notify)

                            this.form.email = '';
                            this.onSubmit();
                        }
                    })
                    .catch(error => {
                        console.log('error: ', error);

                    })
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
	},
};
</script>
