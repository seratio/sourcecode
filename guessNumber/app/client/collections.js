DepositsCollection = new Mongo.Collection('deposits', {connection: null});
new PersistentMinimongo(DepositsCollection);