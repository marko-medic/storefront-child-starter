import get from 'lodash/get';
import { getRandom } from './utils/numUtils';

const app = (param: string) => {
  console.log('hello ' + param);
};

const name = get({ name: 'Max' }, 'name', 'foo!');

app(name + ' ' + getRandom());
