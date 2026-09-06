export default class RecipeManager {
  constructor(book){this.book=book;}
  filter({query='',category=''}){const q=query.trim().toLowerCase();return this.book.recipes.filter(r=>(!category||r.category===category)&&(!q||(r.name+' '+r.category).toLowerCase().includes(q)));}
}
