import { isNull } from 'lodash'

export default {
    modify(user, model) {
        if (!isNull(user)) {
            return user.id == model.user_id
        }
    },
    accept(user, answer) {
        if (!isNull(user)) {
            return user.id == answer.question.user_id
        }
    },
}
