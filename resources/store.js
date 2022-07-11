export default {
    data: {
    },
    getters: {
        vehicles: (state, getters, rootState,rootGetters) => getters.features.garage ?? [],
        properties: (state, getters) => getters.features.property ?? [],
        primaryAddress: (state, getters) => getters.properties?.filter(property => property?.settings?.is_primary_address)[0]
    },
    actions: {
        async createVehicle({ state, commit }, vehicle) {
            let additionalData = {}
            try {
                const { data: {
                    Make: make,
                    Model: model,
                    Series: trim,
                    ModelYear: model_year,
                    VIN: vin,
                    FuelTypePrimary: fuel,
                    Seats: seats,
                    TopSpeedMPH: max_top_speed,
                    TransmissionStyle: transmission,
                    TransmissionSpeeds: transmission_size,
                } } = await axios.get('https://car.metabit.workers.dev/'+ vehicle.settings.vin + '/' + vehicle.settings.model_year, {
                    withCredentials: false,
                }) 
                additionalData = {
                    make, model, trim , model_year, vin, fuel, seats, max_top_speed, transmission, transmission_size,
                };
            } catch (e) {
                console.error('error fetch additional vehicle info, probably a vin problem', e)
            }
            
            try { 
                await axios.post(buildUrl('/api/feature-list'), Object.assign({
                    name: vehicle.name,
                    feature: 'garage',
                    settings: Object.assign(additionalData, vehicle.settings),
                }))
            } catch (e) {
                console.log('failure to create vehicle', e)
                state.errors = e.response.data.errors;
                return;
            }
        }, 
        async createProperty({ state, dispatch }, property) {
            dispatch('createFeature', property)
        }
    }
}