import { ScrollView } from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";

import UserCard from "./components/UserCard";

export default function App() {
  return (
    <SafeAreaView edges={["top", "bottom"]}>
      <ScrollView>
        <UserCard name="John Doe" role="Developer" />
        <UserCard name="Jane Smith" role="Designer" />
        <UserCard name="Sam Wilson" role="Product Manager" />
        <UserCard name="Lisa Brown" role="QA Engineer" />
      </ScrollView>
    </SafeAreaView>
  );
}
