import { StatusBar } from "expo-status-bar";
import { StyleSheet, Text, View } from "react-native";

export default function UserCard({name, role}) {
  return (
    <View style={styles.container}>
      <StatusBar style="auto" />
      <Text style={styles.text}>Name: {name}</Text>
      <Text style={styles.text}>Role: {role}</Text>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#00f",
    borderRadius: 10,
    padding: 20,
    margin: 10,
    alignItems: "center",
    justifyContent: "center",
  },
  text: {
    fontSize: 20,
    color: "#fff",
  },
});