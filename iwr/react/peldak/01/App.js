import { View, FlatList, Image, StyleSheet, Text } from "react-native";
import { SafeAreaView, SafeAreaProvider } from "react-native-safe-area-context";

const DATA = [
  { id: "1", title: "Espresso" },
  { id: "2", title: "Cappuccino" },
  { id: "3", title: "Latte" },
  { id: "4", title: "Americano" },
  { id: "5", title: "Mocha" },
  { id: "6", title: "Flat White" },
  { id: "7", title: "Macchiato" },
  { id: "8", title: "Iced Coffee" },
  { id: "9", title: "Affogato" },
  { id: "10", title: "Irish Coffee" },
  { id: "11", title: "Turkish Coffee" },
  { id: "12", title: "Cold Brew" },
  { id: "13", title: "Ristretto" },
  { id: "14", title: "Lungo" },
  { id: "15", title: "Doppio" },
];

const Item = ({ title }) => (
  <View style={styles.item}>
    <Text style={styles.title}>{title}</Text>
  </View>
);

const ListHeader = () => (
  <View>
    <Image
      source={require("./img/first.png")}
      style={styles.heroImage}
      resizeMode="contain"
    />
    <Text style={styles.header}>☕ Coffee Menu</Text>
  </View>
);

const App = () => {
  return (
    <SafeAreaProvider>
      <SafeAreaView style={styles.container} edges={["top"]}>
        <FlatList
          data={DATA}
          renderItem={({ item }) => <Item title={item.title} />}
          keyExtractor={(item) => item.id}
          ListHeaderComponent={ListHeader}
          contentContainerStyle={styles.listContent}
        />
      </SafeAreaView>
    </SafeAreaProvider>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1, backgroundColor: "#f2f2f2" },
  listContent: { paddingBottom: 16 },
  heroImage: {
    width: "100%",
    height: 160,
    marginTop: 8,
  },
  header: {
    fontSize: 28,
    fontWeight: "700",
    paddingHorizontal: 16,
    paddingVertical: 12,
  },
  item: {
    backgroundColor: "#ffffff",
    padding: 20,
    marginVertical: 8,
    marginHorizontal: 16,
    borderRadius: 10,
    elevation: 2,
    shadowColor: "#000",
    shadowOpacity: 0.1,
    shadowRadius: 4,
  },
  title: { fontSize: 20 },
});

export default App;
